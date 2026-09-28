<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-2xl sm:text-3xl font-bold mb-3">
        <?= $categoriaActual ? e($categoriaActual['nombre']) : 'Catálogo de tacos de billar en Bogotá' ?>
    </h1>
    <p class="text-gray-600 max-w-2xl mb-6">
        Tacos de billar profesionales y para principiantes, desarmables y de una pieza, además de
        virolas, suelas y accesorios. Consulta precio y disponibilidad de cualquier producto por
        WhatsApp.
    </p>

    <form method="get" action="/productos" class="mb-8 flex flex-col sm:flex-row gap-3 max-w-2xl">
        <div class="relative flex-1">
            <label for="buscar-producto" class="sr-only">Buscar producto</label>
            <input type="text" id="buscar-producto" name="buscar" value="<?= e($busqueda) ?>"
                   placeholder="Buscar producto..."
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                <i class="fas fa-search" aria-hidden="true"></i>
                <span class="sr-only">Buscar</span>
            </button>
        </div>
        <label for="filtro-categoria" class="sr-only">Filtrar por categoría</label>
        <select name="categoria" id="filtro-categoria"
                class="border border-gray-300 rounded-lg px-4 py-2 sm:w-56 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Todas las categorías</option>
            <?php foreach ($categorias as $categoria): ?>
                <option value="<?= e($categoria['slug']) ?>" <?= ($categoriaActual['slug'] ?? '') === $categoria['slug'] ? 'selected' : '' ?>>
                    <?= e($categoria['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <noscript><button type="submit" class="bg-blue-600 text-white rounded-lg px-4 py-2">Filtrar</button></noscript>
    </form>

    <?php if ($categoriaActual || $busqueda !== ''): ?>
        <p class="text-sm text-gray-500 mb-4">
            <?= $totalProductos ?> producto<?= $totalProductos === 1 ? '' : 's' ?> encontrado<?= $totalProductos === 1 ? '' : 's' ?>
            <a href="/productos" class="text-blue-600 hover:underline ml-2">Quitar filtros</a>
        </p>
    <?php endif; ?>

    <?php if (empty($productos)): ?>
        <p class="text-gray-600">No se encontraron productos<?= $busqueda !== '' ? ' para "' . e($busqueda) . '"' : '' ?>.</p>
    <?php else: ?>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php foreach ($productos as $producto): ?>
                <?php include __DIR__ . '/_card.php'; ?>
            <?php endforeach; ?>
        </div>

        <?php if ($totalPaginas > 1): ?>
            <?php
                $parametrosPagina = [];
                if ($busqueda !== '') {
                    $parametrosPagina['buscar'] = $busqueda;
                }
                if ($categoriaActual) {
                    $parametrosPagina['categoria'] = $categoriaActual['slug'];
                }
            ?>
            <nav class="mt-8 flex items-center justify-center gap-2" aria-label="Paginación de resultados">
                <?php if ($pagina > 1): ?>
                    <a href="/productos?<?= e(http_build_query($parametrosPagina + ['page' => $pagina - 1])) ?>"
                       class="px-4 py-2 rounded-lg border border-gray-300 text-sm hover:bg-gray-100">
                        <i class="fas fa-chevron-left" aria-hidden="true"></i>
                        <span class="sr-only">Página anterior</span>
                    </a>
                <?php endif; ?>

                <span class="px-4 py-2 text-sm text-gray-600">Página <?= $pagina ?> de <?= $totalPaginas ?></span>

                <?php if ($pagina < $totalPaginas): ?>
                    <a href="/productos?<?= e(http_build_query($parametrosPagina + ['page' => $pagina + 1])) ?>"
                       class="px-4 py-2 rounded-lg border border-gray-300 text-sm hover:bg-gray-100">
                        <span class="sr-only">Página siguiente</span>
                        <i class="fas fa-chevron-right" aria-hidden="true"></i>
                    </a>
                <?php endif; ?>
            </nav>
        <?php endif; ?>
    <?php endif; ?>
</section>
