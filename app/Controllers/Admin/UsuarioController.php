<?php
namespace App\Controllers\Admin;
use PDO;

class UsuarioController {
  private function roles(): array {
    global $pdo;
    return $pdo->query("SELECT * FROM roles ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);
  }

  public function index($req, $res) {
    global $pdo;
    $rows = $pdo->query("SELECT u.id,u.nombre,u.email,u.activo,
      GROUP_CONCAT(r.nombre ORDER BY r.nombre SEPARATOR ', ') AS roles
      FROM usuarios u
      LEFT JOIN usuario_roles ur ON ur.usuario_id=u.id
      LEFT JOIN roles r ON r.id=ur.role_id
      GROUP BY u.id ORDER BY u.id DESC")->fetchAll(PDO::FETCH_ASSOC);

    $html='<h1>Usuarios</h1><p><a href="/admin">Panel</a> | <a href="/admin/usuarios/nuevo">Nuevo</a></p>
           <table border="1" cellpadding="6"><tr><th>ID</th><th>Nombre</th><th>Email</th><th>Activo</th><th>Roles</th><th></th></tr>';
    foreach($rows as $r){
      $html.="<tr><td>{$r['id']}</td><td>{$r['nombre']}</td><td>{$r['email']}</td><td>{$r['activo']}</td><td>{$r['roles']}</td>
              <td><a href=\"/admin/usuarios/{$r['id']}/editar\">Editar</a></td></tr>";
    }
    $html.='</table>';
    $res->getBody()->write($html); return $res;
  }

  public function create($req, $res) {
    $roles = $this->roles();
    $opts = '';
    foreach($roles as $r){ $opts.='<label><input type="checkbox" name="roles[]" value="'.$r['id'].'"> '.$r['nombre'].'</label> '; }
    $html = '<h1>Nuevo usuario</h1><p><a href="/admin/usuarios">← Volver</a></p>
      <form method="post" action="/admin/usuarios">
        <input name="nombre" placeholder="Nombre" required><br>
        <input name="email" type="email" placeholder="Email" required><br>
        <input name="telefono" placeholder="Teléfono"><br>
        <input name="password" type="password" placeholder="Password" required><br>
        <label><input type="checkbox" name="activo" value="1" checked> Activo</label><br>
        <div>Roles: '.$opts.'</div><br>
        <button>Guardar</button>
      </form>';
    $res->getBody()->write($html); return $res;
  }

  public function store($req, $res) {
    global $pdo; $d=(array)$req->getParsedBody();
    $pdo->prepare("INSERT INTO usuarios (nombre,email,telefono,hash_password,rol,activo) VALUES (?,?,?,?,?,?)")
        ->execute([
          trim($d['nombre']??''), trim($d['email']??''), trim($d['telefono']??''),
          password_hash($d['password']??'', PASSWORD_DEFAULT),
          'cliente', isset($d['activo'])?1:0
        ]);
    $uid=(int)$pdo->lastInsertId();
    $roles = $d['roles'] ?? [];
    if ($roles) {
      $ins=$pdo->prepare("INSERT IGNORE INTO usuario_roles (usuario_id, role_id) VALUES (?,?)");
      foreach($roles as $rid){ $ins->execute([$uid,(int)$rid]); }
    }
    return $res->withHeader('Location','/admin/usuarios')->withStatus(302);
  }

  public function edit($req,$res,$args){
    global $pdo; $id=(int)$args['id'];
    $st=$pdo->prepare("SELECT * FROM usuarios WHERE id=?"); $st->execute([$id]); $u=$st->fetch(PDO::FETCH_ASSOC);
    if(!$u){return $res->withStatus(404);}
    $roles = $this->roles();
    $st2=$pdo->prepare("SELECT role_id FROM usuario_roles WHERE usuario_id=?"); $st2->execute([$id]);
    $curr = array_column($st2->fetchAll(PDO::FETCH_ASSOC),'role_id');
    $opts='';
    foreach($roles as $r){
      $chk = in_array($r['id'],$curr)?'checked':'';
      $opts.='<label><input type="checkbox" name="roles[]" value="'.$r['id'].'" '.$chk.'> '.$r['nombre'].'</label> ';
    }
    $html='<h1>Editar usuario</h1><p><a href="/admin/usuarios">← Volver</a></p>
      <form method="post" action="/admin/usuarios/'.$id.'/actualizar">
        <input name="nombre" value="'.htmlspecialchars($u['nombre']).'" required><br>
        <input name="email" type="email" value="'.htmlspecialchars($u['email']).'" required><br>
        <input name="telefono" value="'.htmlspecialchars((string)$u['telefono']).'"><br>
        <input name="password" type="password" placeholder="(dejar en blanco para no cambiar)"><br>
        <label><input type="checkbox" name="activo" value="1" '.($u['activo']?'checked':'').'> Activo</label><br>
        <div>Roles: '.$opts.'</div><br>
        <button>Actualizar</button>
      </form>';
    $res->getBody()->write($html); return $res;
  }

  public function update($req,$res,$args){
    global $pdo; $id=(int)$args['id']; $d=(array)$req->getParsedBody();
    if (!empty($d['password'])) {
      $pdo->prepare("UPDATE usuarios SET nombre=?, email=?, telefono=?, hash_password=?, activo=? WHERE id=?")
          ->execute([trim($d['nombre']??''),trim($d['email']??''),trim($d['telefono']??''),
                     password_hash($d['password'], PASSWORD_DEFAULT), isset($d['activo'])?1:0, $id]);
    } else {
      $pdo->prepare("UPDATE usuarios SET nombre=?, email=?, telefono=?, activo=? WHERE id=?")
          ->execute([trim($d['nombre']??''),trim($d['email']??''),trim($d['telefono']??''), isset($d['activo'])?1:0, $id]);
    }
    // roles
    $pdo->prepare("DELETE FROM usuario_roles WHERE usuario_id=?")->execute([$id]);
    $roles = $d['roles'] ?? [];
    if ($roles) {
      $ins=$pdo->prepare("INSERT IGNORE INTO usuario_roles (usuario_id, role_id) VALUES (?,?)");
      foreach($roles as $rid){ $ins->execute([$id,(int)$rid]); }
    }
    return $res->withHeader('Location','/admin/usuarios')->withStatus(302);
  }
}
