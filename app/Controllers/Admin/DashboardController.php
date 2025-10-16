<?php
namespace App\Controllers\Admin;

class DashboardController {
  public function index($req, $res) {
    if (!isset($_SESSION['admin_id'])) {
      return $res->withHeader('Location','/admin/login')->withStatus(302);
    }
    $html = '<h1>Panel Admin</h1><p>Bienvenido 👋</p>
      <p><a href="/admin/productos">Productos</a> | <a href="/admin/logout">Salir</a></p>';
    $res->getBody()->write($html);
    return $res;
  }
}
