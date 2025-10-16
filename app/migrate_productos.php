<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// Cargar variables de entorno
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Configuración de base de datos
$host = $_ENV['DB_HOST'];
$dbname = $_ENV['DB_NAME'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión a base de datos exitosa.\n";
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage() . "\n");
}

// Directorio de productos del sistema antiguo
$productosDir = __DIR__ . '/../old_productos';

if (!is_dir($productosDir)) {
    die("Directorio de productos no encontrado: $productosDir\n");
}

// Obtener ID de categoría "Tacos" (creada en el seeder)
$stmt = $pdo->prepare("SELECT id FROM categorias WHERE nombre = 'Tacos' LIMIT 1");
$stmt->execute();
$categoria = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$categoria) {
    die("Categoría 'Tacos' no encontrada. Ejecuta primero el seeder.\n");
}

$categoriaId = $categoria['id'];

// Función para generar slug único
function generarSlug($texto, $pdo) {
    // Convertir a minúsculas y reemplazar caracteres especiales
    $slug = mb_strtolower($texto, 'UTF-8');
    $slug = preg_replace('/[^a-z0-9áéíóúñ]+/u', '-', $slug);
    $slug = trim($slug, '-');
    
    // Asegurar que el slug no esté vacío
    if (empty($slug)) {
        $slug = 'producto-' . time();
    }
    
    // Verificar unicidad
    $slugBase = $slug;
    $contador = 1;
    
    while (true) {
        $stmt = $pdo->prepare("SELECT id FROM productos WHERE slug = ? LIMIT 1");
        $stmt->execute([$slug]);
        
        if (!$stmt->fetch()) {
            break; // Slug único encontrado
        }
        
        $slug = $slugBase . '-' . $contador;
        $contador++;
    }
    
    return $slug;
}

// Función para leer archivo info.txt
function leerInfoProducto($archivoInfo) {
    if (!file_exists($archivoInfo)) {
        return null;
    }
    
    $contenido = file_get_contents($archivoInfo);
    $lineas = explode("\n", $contenido);
    
    $producto = [];
    
    foreach ($lineas as $linea) {
        $linea = trim($linea);
        if (empty($linea)) continue;
        
        // Extraer clave y valor
        if (preg_match('/^([^=]+)=\s*"([^"]*)"$/', $linea, $matches)) {
            $clave = trim($matches[1]);
            $valor = $matches[2];
            $producto[$clave] = $valor;
        }
    }
    
    return $producto;
}

// Función para copiar archivos de media
function copiarArchivosMedia($origenDir, $destinoDir, $productoId) {
    $archivosCopiados = [];
    
    if (!is_dir($origenDir)) {
        return $archivosCopiados;
    }
    
    // Crear directorio destino si no existe
    if (!is_dir($destinoDir)) {
        mkdir($destinoDir, 0755, true);
    }
    
    $archivos = glob($origenDir . '/*');
    
    foreach ($archivos as $archivo) {
        if (is_file($archivo)) {
            $extension = pathinfo($archivo, PATHINFO_EXTENSION);
            $nombreArchivo = $productoId . '_' . basename($archivo);
            $destino = $destinoDir . '/' . $nombreArchivo;
            
            if (copy($archivo, $destino)) {
                $archivosCopiados[] = [
                    'nombre_archivo' => $nombreArchivo,
                    'ruta_archivo' => '/media/productos/' . $nombreArchivo,
                    'tipo_media' => in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']) ? 'imagen' : 'video'
                ];
            }
        }
    }
    
    return $archivosCopiados;
}

// Obtener todos los directorios de productos
$directoriosProductos = glob($productosDir . '/*', GLOB_ONLYDIR);

echo "Encontrados " . count($directoriosProductos) . " productos para migrar.\n\n";

$productosInsertados = 0;
$errores = 0;

foreach ($directoriosProductos as $dirProducto) {
    $nombreCarpeta = basename($dirProducto);
    $archivoInfo = $dirProducto . '/info.txt';
    
    echo "Procesando: $nombreCarpeta\n";
    
    // Leer información del producto
    $infoProducto = leerInfoProducto($archivoInfo);
    
    if (!$infoProducto) {
        echo "  ❌ Error: No se pudo leer info.txt\n";
        $errores++;
        continue;
    }
    
    // Validar campos requeridos
    if (!isset($infoProducto['nombre']) || !isset($infoProducto['precio'])) {
        echo "  ❌ Error: Faltan campos requeridos (nombre o precio)\n";
        $errores++;
        continue;
    }
    
    try {
        // Generar slug único
        $nombre = $infoProducto['nombre'];
        $slug = generarSlug($nombre, $pdo);
        
        // Insertar producto
        $stmt = $pdo->prepare("
            INSERT INTO productos (nombre, descripcion, precio, slug, categoria_id, stock, activo, created_at, updated_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
        ");
        
        $descripcion = isset($infoProducto['descripcion']) ? $infoProducto['descripcion'] : '';
        $precio = floatval($infoProducto['precio']);
        $stock = 1; // Por defecto 1 en stock
        $activo = 1; // Activo por defecto
        
        $stmt->execute([$nombre, $descripcion, $precio, $slug, $categoriaId, $stock, $activo]);
        $productoId = $pdo->lastInsertId();
        
        echo "  ✅ Producto insertado con ID: $productoId\n";
        
        // Copiar y registrar imágenes
        $imagenesDir = $dirProducto . '/images';
        $destinoImagenes = __DIR__ . '/../public/media/productos';
        $archivosImagenes = copiarArchivosMedia($imagenesDir, $destinoImagenes, $productoId);
        
        foreach ($archivosImagenes as $archivo) {
            $stmtMedia = $pdo->prepare("
                INSERT INTO producto_media (producto_id, tipo, archivo, created_at) 
                VALUES (?, ?, ?, NOW())
            ");
            $stmtMedia->execute([
                $productoId, 
                $archivo['tipo_media'], 
                $archivo['ruta_archivo']
            ]);
        }
        
        if (count($archivosImagenes) > 0) {
            echo "    📷 " . count($archivosImagenes) . " archivos de media copiados\n";
        }
        
        // Copiar y registrar videos
        $videosDir = $dirProducto . '/videos';
        $destinoVideos = __DIR__ . '/../public/media/productos';
        $archivosVideos = copiarArchivosMedia($videosDir, $destinoVideos, $productoId);
        
        foreach ($archivosVideos as $archivo) {
            $stmtMedia = $pdo->prepare("
                INSERT INTO producto_media (producto_id, tipo, archivo, created_at) 
                VALUES (?, ?, ?, NOW())
            ");
            $stmtMedia->execute([
                $productoId, 
                $archivo['tipo_media'], 
                $archivo['ruta_archivo']
            ]);
        }
        
        if (count($archivosVideos) > 0) {
            echo "    🎥 " . count($archivosVideos) . " videos copiados\n";
        }
        
        $productosInsertados++;
        
    } catch (PDOException $e) {
        echo "  ❌ Error al insertar producto: " . $e->getMessage() . "\n";
        $errores++;
    }
    
    echo "\n";
}

echo "=== RESUMEN DE MIGRACIÓN ===\n";
echo "Productos insertados: $productosInsertados\n";
echo "Errores: $errores\n";
echo "Total procesados: " . ($productosInsertados + $errores) . "\n";

if ($productosInsertados > 0) {
    echo "\n✅ Migración de productos completada exitosamente!\n";
} else {
    echo "\n❌ No se pudo migrar ningún producto.\n";
}