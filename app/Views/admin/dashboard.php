<h1 class="text-xl sm:text-2xl font-bold mb-6">Panel de administración</h1>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
    <div class="bg-white rounded-xl shadow-sm p-5 sm:p-6">
        <p class="text-gray-500 text-sm mb-1">Productos totales</p>
        <p class="text-2xl sm:text-3xl font-bold"><?= (int) $totalProductos ?></p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 sm:p-6">
        <p class="text-gray-500 text-sm mb-1"><i class="fas fa-star text-yellow-500 mr-1" aria-hidden="true"></i>Destacados</p>
        <p class="text-2xl sm:text-3xl font-bold"><?= (int) $totalDestacados ?></p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 sm:p-6">
        <p class="text-gray-500 text-sm mb-1">Sin imágenes</p>
        <p class="text-2xl sm:text-3xl font-bold <?= $sinImagenes > 0 ? 'text-red-500' : '' ?>"><?= (int) $sinImagenes ?></p>
    </div>
</div>

<div class="mt-8 flex flex-col sm:flex-row gap-3">
    <a href="/admin/productos" class="bg-blue-600 hover:bg-blue-500 text-white font-semibold px-5 py-2.5 rounded-lg text-center">
        Ver productos
    </a>
    <a href="/admin/productos/nuevo" class="bg-white border border-gray-300 hover:bg-gray-50 font-semibold px-5 py-2.5 rounded-lg text-center">
        + Agregar producto
    </a>
</div>
