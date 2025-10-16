<?php
namespace App\Middleware;

use PDO;

class AdminOnly {
  private PDO $pdo;
  
  public function __construct(PDO $pdo) {
    $this->pdo = $pdo;
  }
  
  public function __invoke($req, $handler) {
    if (!isset($_SESSION['admin_id'])) {
      $res = new \Slim\Psr7\Response();
      return $res->withHeader('Location','/admin/login')->withStatus(302);
    }
    // check rol admin por tabla roles
    $st = $this->pdo->prepare("SELECT COUNT(*) FROM usuario_roles ur
                         JOIN roles r ON r.id=ur.role_id
                         WHERE ur.usuario_id=? AND r.nombre='admin'");
    $st->execute([$_SESSION['admin_id']]);
    if ((int)$st->fetchColumn() === 0) {
      $res = new \Slim\Psr7\Response();
      $res->getBody()->write('Acceso restringido');
      return $res->withStatus(403);
    }
    return $handler->handle($req);
  }
}
