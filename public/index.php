<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use App\Middleware\AdminOnly;
use App\Controllers\ProductoController;
use App\Support\MercadoPago; // <-- lo usaremos en el checkout // si usas el helper


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();


session_name($_ENV['SESSION_NAME'] ?? 'TACOSSESSID');
session_start();

$app = AppFactory::create();
$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();

// Error handling dev
if (($_ENV['APP_ENV'] ?? 'prod') !== 'prod') {
  $app->addErrorMiddleware(true, true, true);
}

// ====== CONEXIÓN PDO ======
/** @var PDO $pdo */
$pdo = (function() {
  $dsn = "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']};charset=utf8mb4";
  return new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
  ]);
})();

// ====== VISTAS (Plates) ======
$templates = new League\Plates\Engine(__DIR__ . '/../app/Views');

// ====== CONTROLADORES ======
$productoController = new ProductoController($pdo, $templates);

// ====== HELPERS ======
/**
 * Crea preferencia en Mercado Pago y devuelve la URL de checkout (init_point).
 * Lanza RuntimeException si algo sale mal.
 */
/*
function mp_crear_preferencia(array $items, int $pedidoId): string {
  $token = $_ENV['MP_ACCESS_TOKEN'] ?? '';
  if (!$token) {
    throw new RuntimeException('Falta MP_ACCESS_TOKEN en .env');
  }

  $payload = [
    "items" => array_map(function($it) {
      return [
        "title"        => (string)$it['title'],
        "quantity"     => (int)$it['quantity'],
        "currency_id"  => "COP",
        "unit_price"   => (float)$it['unit_price'],
      ];
    }, $items),
    "external_reference" => (string)$pedidoId,
    "back_urls" => [
      "success"  => rtrim($_ENV['APP_URL'], '/') . "/pago/exito",
      "failure"  => rtrim($_ENV['APP_URL'], '/') . "/pago/fallo",
      "pending"  => rtrim($_ENV['APP_URL'], '/') . "/pago/pendiente",
    ],
    "auto_return" => "approved",
    "notification_url" => rtrim($_ENV['APP_URL'], '/') . "/webhooks/mercadopago"
  ];

  $ch = curl_init("https://api.mercadopago.com/checkout/preferences");
  curl_setopt_array($ch, [
    CURLOPT_HTTPHEADER     => ["Authorization: Bearer {$token}", "Content-Type: application/json"],
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT        => 20,
  ]);
  $resp = curl_exec($ch);
  $err  = curl_error($ch);
  $code = (int)curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
  curl_close($ch);

  if ($resp === false || $code >= 400) {
    throw new RuntimeException("Error MP ({$code}): {$err} {$resp}");
  }

  $json = json_decode($resp, true);
  if (!is_array($json) || empty($json['init_point'])) {
    throw new RuntimeException("Respuesta MP inválida: {$resp}");
  }
  return (string)$json['init_point'];
} */

// ====== RUTAS PÚBLICAS ======
// Landing page
$app->get('/', [$productoController, 'landing']);

// API de productos
$app->get('/api/productos', [$productoController, 'indexApi']);
$app->get('/api/productos/destacados', [$productoController, 'destacados']);
$app->get('/api/productos/{slug}', [$productoController, 'showApi']);

// Páginas de productos
$app->get('/productos', [$productoController, 'index']);
$app->get('/productos/{slug}', [$productoController, 'show']);

$app->get('/p/{slug}', function($req, $res, $args) use ($pdo, $templates) {
  $slug = $args['slug'];
  $stmt = $pdo->prepare("SELECT * FROM productos WHERE slug = ?");
  $stmt->execute([$slug]);
  $p = $stmt->fetch(PDO::FETCH_ASSOC);
  if (!$p) { return $res->withStatus(404); }
  $m = $pdo->prepare("SELECT * FROM producto_media WHERE producto_id = ? ORDER BY posicion ASC");
  $m->execute([$p['id']]);
  $media = $m->fetchAll(PDO::FETCH_ASSOC);
  $html = $templates->render('producto', ['p'=>$p, 'media'=>$media]);
  $res->getBody()->write($html);
  return $res;
});

// Carrito (session) + htmx
$app->post('/api/carrito/agregar', function($req, $res) use ($pdo, $templates) {
  $data = (array)$req->getParsedBody();
  $id = (int)($data['producto_id'] ?? 0);
  $q  = (int)($data['cantidad'] ?? 1);
  if ($id < 1 || $q < 1) { return $res->withStatus(400); }

  $stmt = $pdo->prepare("SELECT id, titulo, precio FROM productos WHERE id = ?");
  $stmt->execute([$id]);
  $prod = $stmt->fetch(PDO::FETCH_ASSOC);
  if (!$prod) { return $res->withStatus(404); }

  $_SESSION['cart'] = $_SESSION['cart'] ?? [];
  $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + $q;

  // Render mini-carrito
  $html = $templates->render('partials/mini_carrito', ['cart'=>$_SESSION['cart']]);
  $res->getBody()->write($html);
  return $res;
});

// Checkout (resumen)
$app->get('/checkout', function($req, $res) use ($pdo, $templates) {
  $cart = $_SESSION['cart'] ?? [];
  if (!$cart) { return $res->withHeader('Location','/')->withStatus(302); }

  $ids = array_keys($cart);
  $in  = implode(',', array_fill(0, count($ids), '?'));
  $stmt = $pdo->prepare("SELECT id, titulo, precio FROM productos WHERE id IN ($in)");
  $stmt->execute($ids);
  $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $total = 0;
  foreach ($items as $it) { $total += $it['precio'] * ($cart[$it['id']] ?? 0); }

  $html = $templates->render('checkout', ['items'=>$items, 'cart'=>$cart, 'total'=>$total]);
  $res->getBody()->write($html);
  return $res;
});



// Crear pedido + crear preferencia MP + redirigir
$app->post('/checkout/pagar', function($req, $res) use ($pdo) {
  $d = (array)$req->getParsedBody();
  $email = trim($d['email'] ?? '');
  $tel   = trim($d['telefono'] ?? '');
  $dir   = trim($d['direccion'] ?? '');

  $cart = $_SESSION['cart'] ?? [];
  if (!$cart) { return $res->withHeader('Location','/')->withStatus(302); }

  // Obtener items del carrito
  $ids = array_keys($cart);
  $in  = implode(',', array_fill(0, count($ids), '?'));
  $stmt = $pdo->prepare("SELECT id, titulo, precio FROM productos WHERE id IN ($in)");
  $stmt->execute($ids);
  $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $total = 0;
  foreach ($items as $it) { $total += $it['precio'] * ($cart[$it['id']] ?? 0); }

  // Crear pedido local
  $pstmt = $pdo->prepare("INSERT INTO pedidos (usuario_id, email, telefono, direccion, estado, total, metodo_pago)
                          VALUES (NULL, ?, ?, ?, 'pendiente', ?, 'mercadopago')");
  $pstmt->execute([$email, $tel, $dir, $total]);
  $pedidoId = (int)$pdo->lastInsertId();

  // Guardar items del pedido
  $iStmt = $pdo->prepare("INSERT INTO pedido_items (pedido_id, producto_id, titulo, precio, cantidad)
                          VALUES (?,?,?,?,?)");
  foreach ($items as $it) {
    $iStmt->execute([$pedidoId, $it['id'], $it['titulo'], $it['precio'], $cart[$it['id']]]);
  }

  // Construir items para MP
  $mpItems = array_map(function($it) use ($cart) {
    return [
      "title"      => $it['titulo'],
      "quantity"   => (int)$cart[$it['id']],
      "unit_price" => (float)$it['precio'],
    ];
  }, $items);

  // Crear preferencia y redirigir
  try {
    // Usa el helper si existe; si no, intenta la función mp_crear_preferencia()
    if (class_exists('\\App\\Support\\MercadoPago')) {
      $pref = \App\Support\MercadoPago::crearPreferencia($mpItems, $pedidoId); // ['init_point','id']
      $checkoutUrl = $pref['init_point'];
      $prefId = $pref['id'];
    } else {
      // Compatibilidad con tu función mp_crear_preferencia() que retorna string o array
      $pref = mp_crear_preferencia($mpItems, $pedidoId);
      if (is_array($pref)) {
        $checkoutUrl = $pref['init_point'] ?? '';
        $prefId = $pref['id'] ?? null;
      } else {
        $checkoutUrl = (string)$pref;
        $prefId = null;
      }
    }

    // Guarda la preferencia en el pedido (si tienes las columnas)
    if (!empty($prefId)) {
      $pdo->prepare("UPDATE pedidos SET mp_preference_id=?, referencia_pasarela=? WHERE id=?")
          ->execute([$prefId, $prefId, $pedidoId]);
    }
  } catch (\Throwable $e) {
    $res->getBody()->write("Error al crear preferencia de pago: " . htmlspecialchars($e->getMessage()));
    return $res->withStatus(500);
  }

  unset($_SESSION['cart']);
  return $res->withHeader('Location', $checkoutUrl)->withStatus(302);
});



// Páginas de retorno (éxito/fallo/pendiente)
$app->get('/pago/exito', function($req, $res) {
  $res->getBody()->write('<h1>¡Pago aprobado! 🎉</h1><p>Pronto te contactaremos.</p><p><a href="/">Volver</a></p>');
  return $res;
});
$app->get('/pago/fallo', function($req, $res) {
  $res->getBody()->write('<h1>Pago fallido ❌</h1><p>Inténtalo de nuevo.</p><p><a href="/checkout">Regresar al checkout</a></p>');
  return $res;
});
$app->get('/pago/pendiente', function($req, $res) {
  $res->getBody()->write('<h1>Pago pendiente ⏳</h1><p>Estamos esperando la confirmación.</p><p><a href="/">Volver</a></p>');
  return $res;
});

// Webhook Mercado Pago: aquí solo confirmamos recepción.
// (Luego podemos consultar el pago por ID y marcar el pedido como 'pagado')
$app->post('/webhooks/mercadopago', function($req, $res) use ($pdo) {
  $data = (array)$req->getParsedBody();

  // Si MP envía "data.id" y "type" podemos consultar el pago/preference
  // Ej: $paymentId = $data['data']['id'] ?? null;

  // TODO: Validar firma si usas secret propio (MP_WEBHOOK_SECRET) y
  // consultar el pago para actualizar el estado del pedido a 'pagado'.

  $res->getBody()->write('ok');
  return $res;
});

// ====== RUTAS ADMIN ======
// Login público

$app->get('/admin/login', [\App\Controllers\Admin\AuthController::class, 'form']);
$app->post('/admin/login', [\App\Controllers\Admin\AuthController::class, 'login']);
$app->get('/admin/logout', [\App\Controllers\Admin\AuthController::class, 'logout']);


$app->group('/admin', function(RouteCollectorProxy $group) {
  // Dashboard
  $group->get('', [\App\Controllers\Admin\DashboardController::class, 'index']);

  // Productos
  $group->get('/productos', [\App\Controllers\Admin\ProductoController::class, 'index']);
  $group->get('/productos/nuevo', [\App\Controllers\Admin\ProductoController::class, 'create']);
  $group->post('/productos', [\App\Controllers\Admin\ProductoController::class, 'store']);
  $group->get('/productos/{id}/editar', [\App\Controllers\Admin\ProductoController::class, 'edit']);
  $group->post('/productos/{id}/actualizar', [\App\Controllers\Admin\ProductoController::class, 'update']);
  $group->get('/productos/{id}/eliminar', [\App\Controllers\Admin\ProductoController::class, 'destroy']);

  // Roles
  $group->get('/roles', [\App\Controllers\Admin\RolController::class, 'index']);
  $group->get('/roles/nuevo', [\App\Controllers\Admin\RolController::class, 'create']);
  $group->post('/roles', [\App\Controllers\Admin\RolController::class, 'store']);
  $group->get('/roles/{id}/editar', [\App\Controllers\Admin\RolController::class, 'edit']);
  $group->post('/roles/{id}/actualizar', [\App\Controllers\Admin\RolController::class, 'update']);
  $group->get('/roles/{id}/eliminar', [\App\Controllers\Admin\RolController::class, 'destroy']);

  // Usuarios (cuando pegues UsuarioController)
  $group->get('/usuarios', [\App\Controllers\Admin\UsuarioController::class, 'index']);
  $group->get('/usuarios/nuevo', [\App\Controllers\Admin\UsuarioController::class, 'create']);
  $group->post('/usuarios', [\App\Controllers\Admin\UsuarioController::class, 'store']);
  $group->get('/usuarios/{id}/editar', [\App\Controllers\Admin\UsuarioController::class, 'edit']);
  $group->post('/usuarios/{id}/actualizar', [\App\Controllers\Admin\UsuarioController::class, 'update']);
})->add(new AdminOnly($pdo));

$app->run();
