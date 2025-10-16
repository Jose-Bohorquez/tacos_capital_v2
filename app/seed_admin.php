<?php
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..'); $dotenv->load();

$pdo = new PDO(
  "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']};charset=utf8mb4",
  $_ENV['DB_USER'], $_ENV['DB_PASS'],
  [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

// Crear roles básicos
$roles = [
  ['admin', 'Administrador del sistema con acceso completo'],
  ['user', 'Usuario regular con acceso limitado']
];

foreach ($roles as $rol) {
  $st = $pdo->prepare("SELECT COUNT(*) FROM roles WHERE nombre=?");
  $st->execute([$rol[0]]);
  if (!$st->fetchColumn()) {
    $st = $pdo->prepare("INSERT INTO roles (nombre, descripcion) VALUES (?, ?)");
    $st->execute($rol);
    echo "Rol '{$rol[0]}' creado.\n";
  } else {
    echo "Rol '{$rol[0]}' ya existe.\n";
  }
}

// Crear admin si no existe
$st = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE email=?");
$st->execute(['admin@tacoscapital.com']);
if (!$st->fetchColumn()) {
  $st = $pdo->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
  $st->execute(['Admin', 'admin@tacoscapital.com', password_hash('admin123', PASSWORD_DEFAULT)]);
  $adminId = $pdo->lastInsertId();
  
  // Asignar rol de admin
  $st = $pdo->prepare("SELECT id FROM roles WHERE nombre='admin'");
  $st->execute();
  $adminRolId = $st->fetchColumn();
  
  if ($adminRolId) {
    $st = $pdo->prepare("INSERT INTO usuario_roles (usuario_id, rol_id) VALUES (?, ?)");
    $st->execute([$adminId, $adminRolId]);
    echo "Admin creado y rol asignado.\n";
  }
} else {
  echo "Admin ya existe.\n";
}

// Crear categoría por defecto
$st = $pdo->prepare("SELECT COUNT(*) FROM categorias WHERE slug=?");
$st->execute(['tacos']);
if (!$st->fetchColumn()) {
  $st = $pdo->prepare("INSERT INTO categorias (nombre, descripcion, slug) VALUES (?, ?, ?)");
  $st->execute(['Tacos', 'Tacos de billar profesionales', 'tacos']);
  echo "Categoría 'Tacos' creada.\n";
} else {
  echo "Categoría 'Tacos' ya existe.\n";
}

echo "Seed completado exitosamente.\n";
