<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title><?= e($titulo ?? 'Admin') ?> - Tacos Capital</title>
    <link rel="icon" href="/assets/img/favicon.ico">
    <link rel="stylesheet" href="/assets/css/app.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.5/sweetalert2.all.min.js"></script>
</head>
<body class="min-h-screen bg-gray-100 text-gray-900">
<?php $ruta = Request::path(); ?>
<div class="flex min-h-screen">
    <!-- Sidebar: solo desktop -->
    <aside class="w-60 bg-gray-900 text-white flex-shrink-0 hidden md:flex md:flex-col">
        <div class="p-6 text-xl font-bold border-b border-gray-800">Tacos Capital</div>
        <nav class="mt-4 flex flex-col text-sm flex-1">
            <a href="/admin" class="px-6 py-3 hover:bg-gray-800 <?= $ruta === '/admin' ? 'bg-gray-800 border-l-4 border-blue-500' : '' ?>">
                <i class="fas fa-gauge w-5" aria-hidden="true"></i> Dashboard
            </a>
            <a href="/admin/productos" class="px-6 py-3 hover:bg-gray-800 <?= str_starts_with($ruta, '/admin/productos') ? 'bg-gray-800 border-l-4 border-blue-500' : '' ?>">
                <i class="fas fa-box w-5" aria-hidden="true"></i> Productos
            </a>
        </nav>
        <form action="/admin/logout" method="post" class="p-4 border-t border-gray-800">
            <?= csrf_field() ?>
            <button type="submit" class="text-red-400 hover:text-red-300 text-sm w-full text-left">
                <i class="fas fa-arrow-right-from-bracket w-5" aria-hidden="true"></i> Cerrar sesión
            </button>
        </form>
    </aside>

    <div class="flex-1 flex flex-col min-w-0">
        <!-- Barra superior: solo móvil -->
        <header class="bg-gray-900 text-white px-4 py-3 flex justify-between items-center md:hidden sticky top-0 z-40">
            <span class="font-bold">Tacos Capital — Admin</span>
            <button id="admin-menu-toggle" class="p-2" aria-label="Abrir menú">
                <i class="fas fa-bars text-xl" aria-hidden="true"></i>
            </button>
        </header>
        <nav id="admin-mobile-menu" class="hidden md:hidden bg-gray-900 text-white text-sm">
            <a href="/admin" class="block px-4 py-3 border-t border-gray-800 <?= $ruta === '/admin' ? 'bg-gray-800' : '' ?>">Dashboard</a>
            <a href="/admin/productos" class="block px-4 py-3 border-t border-gray-800 <?= str_starts_with($ruta, '/admin/productos') ? 'bg-gray-800' : '' ?>">Productos</a>
            <form action="/admin/logout" method="post" class="border-t border-gray-800">
                <?= csrf_field() ?>
                <button type="submit" class="block w-full text-left px-4 py-3 text-red-400">Cerrar sesión</button>
            </form>
        </nav>

        <main class="flex-1 p-4 sm:p-6 max-w-6xl w-full mx-auto">
            <?php if ($mensaje = Session::flash('exito')): ?>
                <div class="mb-4 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded text-sm sm:text-base"><?= e($mensaje) ?></div>
            <?php endif; ?>
            <?php if ($mensaje = Session::flash('error')): ?>
                <div class="mb-4 bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded text-sm sm:text-base"><?= e($mensaje) ?></div>
            <?php endif; ?>
            <?= $content ?>
        </main>
    </div>
</div>
<script src="/assets/js/admin.js"></script>
<script src="/assets/js/admin-confirm.js"></script>
</body>
</html>
