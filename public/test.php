<?php
echo "PHP está funcionando correctamente";
echo "<br>";
echo "Fecha: " . date('Y-m-d H:i:s');
echo "<br>";

// Test de conexión a base de datos
try {
    require __DIR__ . '/../vendor/autoload.php';
    
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();
    
    $dsn = "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']};charset=utf8mb4";
    $pdo = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    
    echo "Conexión a base de datos: OK<br>";
    
    // Test de consulta simple
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM productos");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Total productos: " . $result['total'] . "<br>";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
}