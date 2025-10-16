<?php
namespace App\Controllers\Admin;

use PDO;

class AuthController {
  public function form($req, $res) {
    $html = '<h1>Login Admin</h1>
      <form method="post">
        <input name="email" placeholder="Email" />
        <input name="password" type="password" placeholder="Password" />
        <button>Entrar</button>
      </form>';
    $res->getBody()->write($html);
    return $res;
  }

  public function login($req, $res) {
    global $pdo;
    $d = (array)$req->getParsedBody();
    $email = trim($d['email'] ?? '');
    $pass  = $d['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email=? AND activo=1 LIMIT 1");
    $stmt->execute([$email]);
    $u = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($u && password_verify($pass, $u['hash_password'])) {
      // ¿tiene rol admin en la tabla roles o enum?
      $st = $pdo->prepare("SELECT COUNT(*) FROM usuario_roles ur
                           JOIN roles r ON r.id=ur.role_id
                           WHERE ur.usuario_id=? AND r.nombre='admin'");
      $st->execute([$u['id']]);
      if ((int)$st->fetchColumn() > 0 || ($u['rol'] ?? null) === 'admin') {
        $_SESSION['admin_id'] = $u['id'];
        return $res->withHeader('Location','/admin')->withStatus(302);
      }
    }
    $res->getBody()->write('Credenciales inválidas o sin rol admin');
    return $res->withStatus(401);
  }

  public function logout($req, $res) {
    unset($_SESSION['admin_id']);
    return $res->withHeader('Location','/admin/login')->withStatus(302);
  }
}