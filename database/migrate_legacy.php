<?php

/**
 * Migra los productos del sitio viejo (storage/productos/<slug>/info.txt, PHP plano
 * sin BD real) hacia el esquema MySQL nuevo (products/product_images/legacy_slug_map).
 *
 * Uso (una sola vez, desde CLI en el servidor):
 *   php migrate_legacy.php /ruta/al/sitio/viejo/public_html/storage/productos
 */

declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    exit('Este script solo se ejecuta desde la línea de comandos.');
}

$rutaLegacy = $argv[1] ?? null;
if (!$rutaLegacy || !is_dir($rutaLegacy)) {
    exit("Uso: php migrate_legacy.php /ruta/a/storage/productos\n");
}

require __DIR__ . '/../app/Core/Env.php';
Env::load(__DIR__ . '/../.env');
require __DIR__ . '/../app/Core/Database.php';

$db = Database::connection();

function limpiarNombre(string $nombre): string
{
    // Quita prefijos tipo "1, ", "2,", "1TACO" pegado a número, etc. — limpieza mínima
    // y segura; la revisión de ortografía/redacción queda para el admin, no se automatiza.
    $nombre = preg_replace('/^\s*\d+\s*[,.]?\s*/', '', $nombre);
    return trim($nombre);
}

function generarSlug(PDO $db, string $nombre): string
{
    $base = strtolower(trim((string) preg_replace('/[^a-z0-9]+/i', '-', $nombre), '-'));
    $base = $base !== '' ? $base : 'producto';
    $slug = $base;
    $i = 1;

    $stmt = $db->prepare('SELECT COUNT(*) FROM products WHERE slug = :slug');
    while (true) {
        $stmt->execute(['slug' => $slug]);
        if ((int) $stmt->fetchColumn() === 0) {
            return $slug;
        }
        $slug = $base . '-' . (++$i);
    }
}

function parsearPrecio(string $descripcion): ?float
{
    if (preg_match('/(\d[\d.,]*)\s*mil/i', $descripcion, $m)) {
        $numero = (float) str_replace(['.', ','], '', $m[1]);
        return $numero * 1000;
    }
    return null;
}

function parsearInfoTxt(string $ruta): array
{
    $datos = ['nombre' => '', 'precio' => '', 'descripcion' => ''];
    foreach (file($ruta, FILE_IGNORE_NEW_LINES) as $linea) {
        if (!str_contains($linea, '=')) {
            continue;
        }
        [$clave, $valor] = array_map('trim', explode('=', $linea, 2));
        $valor = trim($valor, " \t\"'");
        if (array_key_exists($clave, $datos)) {
            $datos[$clave] = $valor;
        }
    }
    return $datos;
}

$carpetas = array_filter(glob($rutaLegacy . '/*'), 'is_dir');
$migrados = 0;
$conImagenes = 0;

foreach ($carpetas as $carpeta) {
    $slugViejo = basename($carpeta);
    $infoPath = $carpeta . '/info.txt';

    if (!is_file($infoPath)) {
        echo "SKIP {$slugViejo}: sin info.txt\n";
        continue;
    }

    $info = parsearInfoTxt($infoPath);
    $nombre = limpiarNombre($info['nombre'] !== '' ? $info['nombre'] : $slugViejo);
    $descripcion = $info['descripcion'];
    $precio = $info['precio'] !== '' ? (float) preg_replace('/[^\d.]/', '', $info['precio']) : parsearPrecio($descripcion);

    $slugNuevo = generarSlug($db, $nombre);

    $stmt = $db->prepare(
        'INSERT INTO products (nombre, slug, descripcion, precio, created_at) VALUES (:n, :s, :d, :p, NOW())'
    );
    $stmt->execute(['n' => $nombre, 's' => $slugNuevo, 'd' => $descripcion, 'p' => $precio]);
    $productId = (int) $db->lastInsertId();

    $map = $db->prepare(
        'INSERT INTO legacy_slug_map (slug_viejo, slug_nuevo) VALUES (:viejo, :nuevo)
         ON DUPLICATE KEY UPDATE slug_nuevo = VALUES(slug_nuevo)'
    );
    $map->execute(['viejo' => $slugViejo, 'nuevo' => $slugNuevo]);

    $carpetaImagenesDestino = __DIR__ . '/../public/uploads/productos/' . $productId;
    $imagenesOrigen = glob($carpeta . '/images/*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);

    if ($imagenesOrigen) {
        @mkdir($carpetaImagenesDestino, 0755, true);
        $orden = 0;
        foreach ($imagenesOrigen as $origen) {
            $destino = $carpetaImagenesDestino . '/legacy-' . $orden . '-' . basename($origen);
            copy($origen, $destino);

            $insertImg = $db->prepare(
                'INSERT INTO product_images (product_id, url, url_thumb, orden, es_principal)
                 VALUES (:pid, :url, :urlthumb, :orden, :principal)'
            );
            $urlRelativa = 'uploads/productos/' . $productId . '/' . basename($destino);
            $insertImg->execute([
                'pid' => $productId,
                'url' => $urlRelativa,
                'urlthumb' => $urlRelativa,
                'orden' => $orden,
                'principal' => $orden === 0 ? 1 : 0,
            ]);
            $orden++;
        }
        $conImagenes++;
    }

    $migrados++;
    echo "OK {$slugViejo} -> {$slugNuevo} (id {$productId})\n";
}

echo "\nMigración completa: {$migrados} productos, {$conImagenes} con imágenes copiadas.\n";
echo "NOTA: las imágenes se copiaron tal cual (sin reprocesar a WebP) para no perder calidad en\n";
echo "la migración masiva. Súbelas de nuevo desde el admin si quieres que pasen por el pipeline WebP.\n";
