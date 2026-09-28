<?php

final class ProductImage extends Model
{
    private const EXTENSIONES_PERMITIDAS = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
    private const MIME_PERMITIDOS = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    private const TAMANO_MAXIMO = 8 * 1024 * 1024; // 8MB
    private const ANCHO_PRINCIPAL = 1600;
    private const ANCHO_MINIATURA = 500;

    public function agregarDesdeUpload(int $productId, array $archivo, int $orden): ?array
    {
        $error = $this->validar($archivo);
        if ($error !== null) {
            app_log("Upload rechazado producto {$productId}: {$error}");
            return null;
        }

        $carpeta = $this->carpetaProducto($productId);
        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0755, true);
        }

        $nombreBase = 'imagen-' . $orden . '-' . bin2hex(random_bytes(6));
        $rutaPrincipal = $carpeta . '/' . $nombreBase . '.webp';
        $rutaThumb = $carpeta . '/' . $nombreBase . '_thumb.webp';

        if (!$this->procesarImagen($archivo['tmp_name'], $rutaPrincipal, self::ANCHO_PRINCIPAL)) {
            return null;
        }
        $this->procesarImagen($archivo['tmp_name'], $rutaThumb, self::ANCHO_MINIATURA);

        $urlPrincipal = "uploads/productos/{$productId}/{$nombreBase}.webp";
        $urlThumb = "uploads/productos/{$productId}/{$nombreBase}_thumb.webp";

        $stmt = $this->db->prepare(
            'INSERT INTO product_images (product_id, url, url_thumb, orden, es_principal)
             VALUES (:pid, :url, :thumb, :orden, :principal)'
        );
        $stmt->execute([
            'pid' => $productId,
            'url' => $urlPrincipal,
            'thumb' => $urlThumb,
            'orden' => $orden,
            'principal' => $orden === 0 ? 1 : 0,
        ]);

        return ['url' => $urlPrincipal, 'url_thumb' => $urlThumb];
    }

    public function eliminar(int $imagenId, int $productId): void
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM product_images WHERE id = :id AND product_id = :pid'
        );
        $stmt->execute(['id' => $imagenId, 'pid' => $productId]);
        $imagen = $stmt->fetch();

        if (!$imagen) {
            return;
        }

        $base = __DIR__ . '/../../public_html/';
        @unlink($base . $imagen['url']);
        @unlink($base . $imagen['url_thumb']);

        $del = $this->db->prepare('DELETE FROM product_images WHERE id = :id');
        $del->execute(['id' => $imagenId]);
    }

    public function hacerPrincipal(int $imagenId, int $productId): void
    {
        $quitar = $this->db->prepare('UPDATE product_images SET es_principal = 0 WHERE product_id = :pid');
        $quitar->execute(['pid' => $productId]);

        $poner = $this->db->prepare(
            'UPDATE product_images SET es_principal = 1 WHERE id = :id AND product_id = :pid'
        );
        $poner->execute(['id' => $imagenId, 'pid' => $productId]);
    }

    /**
     * Reprocesa una imagen ya subida (JPG/PNG/GIF, típicamente migrada del sitio viejo) a WebP
     * usando el mismo pipeline de agregarDesdeUpload(), y borra los archivos originales.
     */
    public function optimizarAWebp(int $imagenId, int $productId): bool
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM product_images WHERE id = :id AND product_id = :pid'
        );
        $stmt->execute(['id' => $imagenId, 'pid' => $productId]);
        $imagen = $stmt->fetch();

        if (!$imagen) {
            return false;
        }

        if (str_ends_with($imagen['url'], '.webp') && str_ends_with($imagen['url_thumb'], '.webp')) {
            return true; // ya está en WebP, nada que hacer
        }

        $base = __DIR__ . '/../../public_html/';
        $origenAbsoluto = $base . $imagen['url'];

        if (!is_file($origenAbsoluto)) {
            return false;
        }

        $carpeta = $this->carpetaProducto($productId);
        $nombreBase = 'imagen-' . $imagen['orden'] . '-' . bin2hex(random_bytes(6));
        $rutaPrincipal = $carpeta . '/' . $nombreBase . '.webp';
        $rutaThumb = $carpeta . '/' . $nombreBase . '_thumb.webp';

        if (!$this->procesarImagen($origenAbsoluto, $rutaPrincipal, self::ANCHO_PRINCIPAL)) {
            return false;
        }
        $this->procesarImagen($origenAbsoluto, $rutaThumb, self::ANCHO_MINIATURA);

        $urlPrincipal = "uploads/productos/{$productId}/{$nombreBase}.webp";
        $urlThumb = "uploads/productos/{$productId}/{$nombreBase}_thumb.webp";

        $update = $this->db->prepare(
            'UPDATE product_images SET url = :url, url_thumb = :thumb WHERE id = :id'
        );
        $update->execute(['url' => $urlPrincipal, 'thumb' => $urlThumb, 'id' => $imagenId]);

        // Borra el/los archivo(s) original(es) solo si son distintos de los nuevos
        if ($imagen['url'] !== $urlPrincipal) {
            @unlink($base . $imagen['url']);
        }
        if ($imagen['url_thumb'] !== $imagen['url'] && $imagen['url_thumb'] !== $urlThumb) {
            @unlink($base . $imagen['url_thumb']);
        }

        return true;
    }

    public function eliminarCarpetaProducto(int $productId): void
    {
        $carpeta = $this->carpetaProducto($productId);
        if (!is_dir($carpeta)) {
            return;
        }

        foreach (glob($carpeta . '/*') as $archivo) {
            @unlink($archivo);
        }
        @rmdir($carpeta);
    }

    private function validar(array $archivo): ?string
    {
        if (($archivo['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return 'error de subida';
        }

        if ($archivo['size'] > self::TAMANO_MAXIMO) {
            return 'archivo demasiado grande';
        }

        $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, self::EXTENSIONES_PERMITIDAS, true)) {
            return 'extensión no permitida';
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $archivo['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mime, self::MIME_PERMITIDOS, true)) {
            return "tipo MIME real no permitido ({$mime})";
        }

        if (@getimagesize($archivo['tmp_name']) === false) {
            return 'el archivo no es una imagen válida';
        }

        return null;
    }

    private function procesarImagen(string $origen, string $destino, int $anchoMaximo): bool
    {
        $info = @getimagesize($origen);
        if ($info === false) {
            return false;
        }

        [$anchoOriginal, $altoOriginal, $tipo] = $info;

        $imagen = match ($tipo) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($origen),
            IMAGETYPE_PNG => imagecreatefrompng($origen),
            IMAGETYPE_GIF => imagecreatefromgif($origen),
            IMAGETYPE_WEBP => imagecreatefromwebp($origen),
            default => false,
        };

        if ($imagen === false) {
            return false;
        }

        $ratio = min(1, $anchoMaximo / $anchoOriginal);
        $anchoNuevo = (int) round($anchoOriginal * $ratio);
        $altoNuevo = (int) round($altoOriginal * $ratio);

        $lienzo = imagecreatetruecolor($anchoNuevo, $altoNuevo);
        imagealphablending($lienzo, false);
        imagesavealpha($lienzo, true);
        imagecopyresampled($lienzo, $imagen, 0, 0, 0, 0, $anchoNuevo, $altoNuevo, $anchoOriginal, $altoOriginal);

        $resultado = imagewebp($lienzo, $destino, 82);

        imagedestroy($imagen);
        imagedestroy($lienzo);

        return $resultado;
    }

    private function carpetaProducto(int $productId): string
    {
        return __DIR__ . '/../../public_html/uploads/productos/' . $productId;
    }
}
