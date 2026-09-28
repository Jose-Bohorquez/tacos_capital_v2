<?php

declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/../storage/logs/php_errors.log');

require __DIR__ . '/../app/Core/Env.php';
Env::load(__DIR__ . '/../.env');

spl_autoload_register(function (string $class): void {
    $prefijos = [
        __DIR__ . '/../app/Core/',
        __DIR__ . '/../app/Middleware/',
        __DIR__ . '/../app/Models/',
        __DIR__ . '/../app/Controllers/',
        __DIR__ . '/../app/Controllers/Admin/',
    ];

    foreach ($prefijos as $ruta) {
        $archivo = $ruta . $class . '.php';
        if (is_file($archivo)) {
            require $archivo;
            return;
        }
    }
});

require __DIR__ . '/../app/Core/helpers.php';

Session::start();

$router = new Router();

$router->get('/', [HomeController::class, 'index']);
$router->get('/productos', [ProductController::class, 'index']);
$router->get('/producto/{slug}', [ProductController::class, 'show']);
$router->get('/productos/detalle.php', [ProductController::class, 'redirectLegacy']);
$router->get('/contacto', [ContactController::class, 'index']);
$router->get('/sitemap.xml', [SitemapController::class, 'index']);

$router->get('/admin/login', [AdminAuthController::class, 'showLogin']);
$router->post('/admin/login', [AdminAuthController::class, 'login']);
$router->post('/admin/logout', [AdminAuthController::class, 'logout']);
$router->get('/admin', [AdminDashboardController::class, 'index']);
$router->get('/admin/productos', [AdminProductController::class, 'index']);
$router->get('/admin/productos/nuevo', [AdminProductController::class, 'create']);
$router->post('/admin/productos', [AdminProductController::class, 'store']);
$router->get('/admin/productos/{id}/editar', [AdminProductController::class, 'edit']);
$router->post('/admin/productos/{id}', [AdminProductController::class, 'update']);
$router->post('/admin/productos/{id}/eliminar', [AdminProductController::class, 'destroy']);
$router->post('/admin/productos/{id}/destacado', [AdminProductController::class, 'toggleDestacado']);
$router->post('/admin/productos/{id}/imagenes/{imagenId}/eliminar', [AdminProductController::class, 'destroyImage']);
$router->post('/admin/productos/{id}/imagenes/{imagenId}/principal', [AdminProductController::class, 'setImagenPrincipal']);
$router->post('/admin/productos/{id}/imagenes/{imagenId}/optimizar', [AdminProductController::class, 'optimizarImagen']);

$router->dispatch(Request::method(), Request::path());
