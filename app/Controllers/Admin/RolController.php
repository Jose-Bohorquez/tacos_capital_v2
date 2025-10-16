<?php
namespace App\Controllers\Admin;
use PDO;

class RolController {
  private function viewHeader(): string {
    return '<p><a href="/admin">Panel</a> | <a href="/admin/roles">Roles</a></p>';
  }

  public function index($req, $res) {
    global $pdo;
    $rows = $pdo->query("SELECT * FROM roles ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
    $html = '<h1>Roles</h1>'.$this->viewHeader().'<p><a href="/admin/roles/nuevo">Nuevo</a></p><table border="1" cellpadding="6"><tr><th>ID</th><th>Nombre</th><th>Desc</th><th></th></tr>';
    foreach ($rows as $r) {
      $html .= "<tr><td>{$r['id']}</td><td>{$r['nombre']}</td><td>{$r['descripcion']}</td>
                <td><a href=\"/admin/roles/{$r['id']}/editar\">Editar</a> |
                    <a href=\"/admin/roles/{$r['id']}/eliminar\" onclick=\"return confirm('¿Eliminar?')\">Eliminar</a></td></tr>";
    }
    $html .= '</table>';
    $res->getBody()->write($html);
    return $res;
  }

  public function create($req, $res) {
    $html = '<h1>Nuevo rol</h1>'.$this->viewHeader().'
      <form method="post" action="/admin/roles">
        <input name="nombre" placeholder="nombre (ej: admin)" required />
        <input name="descripcion" placeholder="descripción" />
        <button>Guardar</button>
      </form>';
    $res->getBody()->write($html); return $res;
  }

  public function store($req, $res) {
    global $pdo; $d=(array)$req->getParsedBody();
    $pdo->prepare("INSERT INTO roles (nombre, descripcion) VALUES (?,?)")
        ->execute([trim($d['nombre']??''), trim($d['descripcion']??'')]);
    return $res->withHeader('Location','/admin/roles')->withStatus(302);
  }

  public function edit($req, $res, $args) {
    global $pdo; $id=(int)$args['id'];
    $st=$pdo->prepare("SELECT * FROM roles WHERE id=?"); $st->execute([$id]); $r=$st->fetch(PDO::FETCH_ASSOC);
    if(!$r){return $res->withStatus(404);}
    $html = '<h1>Editar rol</h1>'.$this->viewHeader().'
      <form method="post" action="/admin/roles/'.$id.'/actualizar">
        <input name="nombre" value="'.htmlspecialchars($r['nombre']).'" required />
        <input name="descripcion" value="'.htmlspecialchars((string)$r['descripcion']).'" />
        <button>Actualizar</button>
      </form>';
    $res->getBody()->write($html); return $res;
  }

  public function update($req, $res, $args) {
    global $pdo; $id=(int)$args['id']; $d=(array)$req->getParsedBody();
    $pdo->prepare("UPDATE roles SET nombre=?, descripcion=? WHERE id=?")
        ->execute([trim($d['nombre']??''), trim($d['descripcion']??''), $id]);
    return $res->withHeader('Location','/admin/roles')->withStatus(302);
  }

  public function destroy($req, $res, $args) {
    global $pdo; $id=(int)$args['id'];
    $pdo->prepare("DELETE FROM roles WHERE id=?")->execute([$id]);
    return $res->withHeader('Location','/admin/roles')->withStatus(302);
  }
}
