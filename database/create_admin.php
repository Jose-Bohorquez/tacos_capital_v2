<?php

/**
 * Crea (o resetea la contraseña de) un usuario admin real, con password_hash().
 * Uso: php create_admin.php usuario contraseña
 */

declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    exit('Este script solo se ejecuta desde la línea de comandos.');
}

[, $usuario, $password] = array_pad($argv, 3, null);

if (!$usuario || !$password || strlen($password) < 10) {
    exit("Uso: php create_admin.php usuario contraseña\n(la contraseña debe tener al menos 10 caracteres)\n");
}

require __DIR__ . '/../app/Core/Env.php';
Env::load(__DIR__ . '/../.env');
require __DIR__ . '/../app/Core/Database.php';

$db = Database::connection();
$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $db->prepare(
    'INSERT INTO admins (username, password_hash, created_at) VALUES (:u, :h, NOW())
     ON DUPLICATE KEY UPDATE password_hash = VALUES(password_hash)'
);
$stmt->execute(['u' => $usuario, 'h' => $hash]);

echo "Listo: admin '{$usuario}' creado/actualizado.\n";
