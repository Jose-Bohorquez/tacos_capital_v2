<?php
namespace App\Controllers\Admin;
use PDO;

class ProductoController {
  private function auth($res) {
    if (!isset($_SESSION['admin_id'])) {
      return $res->withHeader('Location','/admin/login')->withStatus(302);
    }
    return null;
  }

  public function index($req, $res) {
    if ($redir = $this->auth($res)) return $redir;
    global $pdo;
    $rows = $pdo->query("SELECT id,titulo,slug,precio,stock,destacado FROM productos ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
    $html = '<h1>Productos</h1><p><a href="/admin">← Panel</a> | <a href="/admin/productos/nuevo">Nuevo</a></p>
    <table border="1" cellpadding="6"><tr><th>ID</th><th>Título</th><th>Precio</th><th>Stock</th><th>Dest</th><th></th></tr>';
    foreach ($rows as $r) {
      $html .= "<tr><td>{$r['id']}</td><td>{$r['titulo']}</td><td>{$r['precio']}</td><td>{$r['stock']}</td><td>{$r['destacado']}</td>
               <td><a href=\"/admin/productos/{$r['id']}/editar\">Editar</a> |
                   <a href=\"/admin/productos/{$r['id']}/eliminar\" onclick=\"return confirm('¿Eliminar?')\">Eliminar</a></td></tr>";
    }
    $html .= '</table>';
    $res->getBody()->write($html);
    return $res;
  }

  public function create($req, $res) {
    if ($redir = $this->auth($res)) return $redir;
    $html = '<h1>Nuevo producto</h1>
      <form method="post" action="/admin/productos" enctype="multipart/form-data">
        <input name="titulo" placeholder="Título" required><br>
        <input name="slug" placeholder="slug-url"><br>
        <textarea name="descripcion" placeholder="Descripción"></textarea><br>
        <input name="precio" type="number" step="0.01" placeholder="Precio" required><br>
        <input name="stock" type="number" placeholder="Stock" value="0"><br>
        <label><input type="checkbox" name="destacado" value="1"> Destacado</label><br>
        <input type="file" name="imagen" accept="image/*"><br><br>
        <button>Guardar</button>
      </form>';
    $res->getBody()->write($html);
    return $res;
  }

  public function store($req, $res) {
    if ($redir = $this->auth($res)) return $redir;
    global $pdo;

    $d = (array)$req->getParsedBody();
    $titulo = trim($d['titulo'] ?? '');
    $slug   = trim($d['slug'] ?? '');
    $desc   = trim($d['descripcion'] ?? '');
    $precio = (float)($d['precio'] ?? 0);
    $stock  = (int)($d['stock'] ?? 0);
    $dest   = isset($d['destacado']) ? 1 : 0;

    // slug autogenerado y único
    if ($slug==='') {
      $slug = preg_replace('~[^a-z0-9-]+~','-', strtolower(iconv('UTF-8','ASCII//TRANSLIT',$titulo)));
      $slug = trim($slug,'-');
    }
    $exists = $pdo->prepare("SELECT COUNT(*) FROM productos WHERE slug=?");
    $try=$slug; $i=2;
    while(true){ $exists->execute([$try]); if(!$exists->fetchColumn()){ $slug=$try; break; } $try=$slug.'-'.$i++; }

    $stmt = $pdo->prepare("INSERT INTO productos (titulo,slug,descripcion,precio,stock,destacado) VALUES (?,?,?,?,?,?)");
    $stmt->execute([$titulo,$slug,$desc,$precio,$stock,$dest]);
    $pid = (int)$pdo->lastInsertId();

    // imagen portada (posicion=1)
    if (!empty($_FILES['imagen']['tmp_name'])) {
      $ext = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
      if (!in_array($ext, ['jpg','jpeg','png','webp','avif'])) { $ext = 'webp'; }
      $rel = "/media/{$slug}-cover.$ext";
      $abs = __DIR__ . '/../../../public' . $rel;
      @move_uploaded_file($_FILES['imagen']['tmp_name'], $abs);

      $s2 = $pdo->prepare("INSERT INTO producto_media (producto_id,tipo,url,posicion) VALUES (?,?,?,1)");
      $s2->execute([$pid,'imagen',$rel]);
    }

    return $res->withHeader('Location','/admin/productos')->withStatus(302);
  }

  public function edit($req, $res, $args) {
    if ($redir = $this->auth($res)) return $redir;
    global $pdo; $id=(int)$args['id'];
    $st=$pdo->prepare("SELECT * FROM productos WHERE id=?"); $st->execute([$id]); $p=$st->fetch(PDO::FETCH_ASSOC);
    if(!$p){return $res->withStatus(404);}
    $html = '<h1>Editar producto</h1>
      <form method="post" action="/admin/productos/'.$id.'/actualizar" enctype="multipart/form-data">
        <input name="titulo" value="'.htmlspecialchars($p['titulo']).'" required><br>
        <input name="slug" value="'.htmlspecialchars($p['slug']).'"><br>
        <textarea name="descripcion">'.htmlspecialchars((string)$p['descripcion']).'</textarea><br>
        <input name="precio" type="number" step="0.01" value="'.htmlspecialchars($p['precio']).'" required><br>
        <input name="stock" type="number" value="'.(int)$p['stock'].'"><br>
        <label><input type="checkbox" name="destacado" value="1" '.($p['destacado']?'checked':'').'> Destacado</label><br>
        <p>Reemplazar portada: <input type="file" name="imagen" accept="image/*"></p>
        <button>Actualizar</button>
      </form>';
    $res->getBody()->write($html);
    return $res;
  }

  public function update($req, $res, $args) {
    if ($redir = $this->auth($res)) return $redir;
    global $pdo; $id=(int)$args['id']; $d=(array)$req->getParsedBody();
    $titulo=trim($d['titulo']??''); $slug=trim($d['slug']??''); $desc=trim($d['descripcion']??'');
    $precio=(float)($d['precio']??0); $stock=(int)($d['stock']??0); $dest=isset($d['destacado'])?1:0;

    if ($slug==='') {
      $slug = preg_replace('~[^a-z0-9-]+~','-', strtolower(iconv('UTF-8','ASCII//TRANSLIT',$titulo)));
      $slug = trim($slug,'-');
    }
    $st=$pdo->prepare("SELECT COUNT(*) FROM productos WHERE slug=? AND id<>?");
    $st->execute([$slug,$id]);
    if($st->fetchColumn()>0){ $slug.='-'.time(); }

    $pdo->prepare("UPDATE productos SET titulo=?, slug=?, descripcion=?, precio=?, stock=?, destacado=?, actualizado_en=NOW() WHERE id=?")
        ->execute([$titulo,$slug,$desc,$precio,$stock,$dest,$id]);

    if (!empty($_FILES['imagen']['tmp_name'])) {
      $ext = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
      if (!in_array($ext, ['jpg','jpeg','png','webp','avif'])) { $ext='webp'; }
      $rel = "/media/{$slug}-cover.$ext";
      $abs = __DIR__ . '/../../../public' . $rel;
      @move_uploaded_file($_FILES['imagen']['tmp_name'], $abs);

      $c=$pdo->prepare("SELECT COUNT(*) FROM producto_media WHERE producto_id=? AND posicion=1");
      $c->execute([$id]);
      if($c->fetchColumn()>0){
        $pdo->prepare("UPDATE producto_media SET url=? WHERE producto_id=? AND posicion=1")->execute([$rel,$id]);
      } else {
        $pdo->prepare("INSERT INTO producto_media (producto_id,tipo,url,posicion) VALUES (?,?,?,1)")
            ->execute([$id,'imagen',$rel]);
      }
    }
    return $res->withHeader('Location','/admin/productos')->withStatus(302);
  }

  public function destroy($req, $res, $args) {
    if ($redir = $this->auth($res)) return $redir;
    global $pdo; $id=(int)$args['id'];
    $pdo->prepare("DELETE FROM productos WHERE id=?")->execute([$id]); // ON DELETE CASCADE borra media
    return $res->withHeader('Location','/admin/productos')->withStatus(302);
  }
}
