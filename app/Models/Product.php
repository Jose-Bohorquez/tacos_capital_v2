<?php

final class Product extends Model
{
    public function all(string $search = '', ?int $categoryId = null, int $limite = 0, int $offset = 0): array
    {
        $condiciones = [];
        $parametros = [];

        if ($search !== '') {
            $condiciones[] = 'nombre LIKE :search';
            $parametros['search'] = '%' . $search . '%';
        }

        if ($categoryId !== null) {
            $condiciones[] = 'category_id = :category_id';
            $parametros['category_id'] = $categoryId;
        }

        $where = $condiciones ? 'WHERE ' . implode(' AND ', $condiciones) : '';
        $limitSql = $limite > 0 ? ' LIMIT :limite OFFSET :offset' : '';
        $stmt = $this->db->prepare("SELECT * FROM products {$where} ORDER BY created_at DESC{$limitSql}");
        foreach ($parametros as $clave => $valor) {
            $stmt->bindValue($clave, $valor);
        }
        if ($limite > 0) {
            $stmt->bindValue('limite', $limite, PDO::PARAM_INT);
            $stmt->bindValue('offset', $offset, PDO::PARAM_INT);
        }
        $stmt->execute();

        $productos = $stmt->fetchAll();
        foreach ($productos as &$producto) {
            $producto['imagenes'] = $this->imagenesDe((int) $producto['id']);
        }
        return $productos;
    }

    /**
     * Total de productos que coinciden con los mismos filtros de all(), sin paginar —
     * usado para calcular el número de páginas en /productos.
     */
    public function countAll(string $search = '', ?int $categoryId = null): int
    {
        $condiciones = [];
        $parametros = [];

        if ($search !== '') {
            $condiciones[] = 'nombre LIKE :search';
            $parametros['search'] = '%' . $search . '%';
        }

        if ($categoryId !== null) {
            $condiciones[] = 'category_id = :category_id';
            $parametros['category_id'] = $categoryId;
        }

        $where = $condiciones ? 'WHERE ' . implode(' AND ', $condiciones) : '';
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM products {$where}");
        $stmt->execute($parametros);
        return (int) $stmt->fetchColumn();
    }

    public function findBySlug(string $slug): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM products WHERE slug = :slug LIMIT 1');
        $stmt->execute(['slug' => $slug]);
        $producto = $stmt->fetch();

        if (!$producto) {
            return null;
        }

        $producto['imagenes'] = $this->imagenesDe((int) $producto['id']);
        return $producto;
    }

    public function destacados(int $limite = 8): array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM products WHERE destacado = 1 ORDER BY created_at DESC LIMIT :limite'
        );
        $stmt->bindValue('limite', $limite, PDO::PARAM_INT);
        $stmt->execute();

        $productos = $stmt->fetchAll();
        foreach ($productos as &$producto) {
            $producto['imagenes'] = $this->imagenesDe((int) $producto['id']);
        }
        return $productos;
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM products WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $producto = $stmt->fetch();

        if (!$producto) {
            return null;
        }

        $producto['imagenes'] = $this->imagenesDe($id);
        return $producto;
    }

    private function imagenesDe(int $productId): array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM product_images WHERE product_id = :id ORDER BY orden ASC'
        );
        $stmt->execute(['id' => $productId]);
        return $stmt->fetchAll();
    }

    public function create(string $nombre, string $slug, string $descripcion, ?float $precio, bool $destacado = false, ?int $categoryId = null): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO products (nombre, slug, descripcion, precio, destacado, category_id, created_at)
             VALUES (:nombre, :slug, :descripcion, :precio, :destacado, :category_id, NOW())'
        );
        $stmt->execute([
            'nombre' => $nombre,
            'slug' => $slug,
            'descripcion' => $descripcion,
            'precio' => $precio,
            'destacado' => $destacado ? 1 : 0,
            'category_id' => $categoryId,
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, string $nombre, string $descripcion, ?float $precio, bool $destacado = false, ?int $categoryId = null): void
    {
        $stmt = $this->db->prepare(
            'UPDATE products SET nombre = :nombre, descripcion = :descripcion, precio = :precio,
             destacado = :destacado, category_id = :category_id, updated_at = NOW() WHERE id = :id'
        );
        $stmt->execute([
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'precio' => $precio,
            'destacado' => $destacado ? 1 : 0,
            'category_id' => $categoryId,
            'id' => $id,
        ]);
    }

    public function toggleDestacado(int $id): void
    {
        $stmt = $this->db->prepare(
            'UPDATE products SET destacado = NOT destacado WHERE id = :id'
        );
        $stmt->execute(['id' => $id]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM products WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    public function slugExists(string $slug): bool
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM products WHERE slug = :slug');
        $stmt->execute(['slug' => $slug]);
        return (int) $stmt->fetchColumn() > 0;
    }

    public function generarSlugUnico(string $nombre): string
    {
        $base = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $nombre), '-'));
        $base = $base !== '' ? $base : 'producto';
        $slug = $base;
        $i = 1;
        while ($this->slugExists($slug)) {
            $slug = $base . '-' . (++$i);
        }
        return $slug;
    }
}
