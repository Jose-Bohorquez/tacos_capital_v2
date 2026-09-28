<style>
    /* CSS propio para los elementos nuevos de esta vista. No se usan clases Tailwind que no
       existieran ya en el archivo original: app.css es un build ESTÁTICO y purgado (no hay
       Node/Tailwind en este hosting para recompilarlo), así que cualquier utilidad nueva que no
       estuviera ya en uso en otra vista simplemente no tiene CSS generado. */
    .buscador-productos-wrap { position: relative; margin-bottom: 1rem; }
    .buscador-productos-wrap .icono-buscar {
        position: absolute; left: .75rem; top: 50%; transform: translateY(-50%);
        color: #9ca3af; font-size: .875rem; pointer-events: none;
    }
    #buscador-productos {
        width: 100%; padding: .625rem .75rem .625rem 2.25rem;
        border: 1px solid #d1d5db; border-radius: .5rem; font-size: .875rem;
    }
    #buscador-productos:focus {
        outline: none; border-color: #3b82f6; box-shadow: 0 0 0 2px rgba(59,130,246,.35);
    }
    .tarjeta-producto .btn-touch { padding: .5rem 0; display: inline-block; }
    #tabla-productos_wrapper .dataTables_paginate .paginate_button {
        padding: .375rem .75rem; margin-left: .25rem; border-radius: .5rem; cursor: pointer;
        border: 1px solid #e5e7eb; font-size: .8125rem; display: inline-block;
    }
    #tabla-productos_wrapper .dataTables_paginate .paginate_button.current {
        background: #2563eb !important; color: #fff !important; border-color: #2563eb;
    }
    #tabla-productos_wrapper .dataTables_paginate .paginate_button.disabled {
        opacity: .4; cursor: default;
    }
    #tabla-productos_wrapper .dataTables_info { color: #6b7280; font-size: .8125rem; }
    #tabla-productos_wrapper .dataTables_length select {
        border: 1px solid #d1d5db; border-radius: .375rem; padding: .25rem .5rem; margin: 0 .25rem;
    }
    #tabla-productos_wrapper .dataTables_length,
    #tabla-productos_wrapper .dataTables_info,
    #tabla-productos_wrapper .dataTables_paginate {
        margin-top: .75rem;
    }
</style>

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
    <h1 class="text-xl sm:text-2xl font-bold">Productos <span class="text-gray-400 font-normal text-base">(<?= count($productos) ?>)</span></h1>
    <a href="/admin/productos/nuevo" class="bg-blue-600 hover:bg-blue-500 text-white font-semibold px-4 py-2 rounded-lg text-sm text-center">
        + Agregar producto
    </a>
</div>

<?php if (empty($productos)): ?>
    <div class="bg-white rounded-xl shadow-sm p-8 text-center text-gray-500">
        Todavía no hay productos. <a href="/admin/productos/nuevo" class="text-blue-600 hover:underline">Agrega el primero</a>.
    </div>
<?php else: ?>

<!-- Buscador único: filtra tanto las tarjetas (móvil) como la tabla DataTables (sm+) -->
<div class="buscador-productos-wrap">
    <i class="fas fa-search icono-buscar" aria-hidden="true"></i>
    <input type="search" id="buscador-productos" placeholder="Buscar producto por nombre…" aria-label="Buscar producto">
</div>
<p id="buscador-sin-resultados" class="hidden bg-white rounded-xl shadow-sm p-6 text-center text-gray-500 text-sm mb-4">
    Sin resultados para "<span id="buscador-termino"></span>". <button type="button" id="buscador-limpiar" class="text-blue-600 hover:underline">Limpiar búsqueda</button>.
</p>

<!-- Tarjetas: solo móvil -->
<div class="sm:hidden space-y-3" id="tarjetas-productos">
    <?php foreach ($productos as $producto): ?>
    <div class="bg-white rounded-xl shadow-sm p-4 tarjeta-producto" data-nombre="<?= e(mb_strtolower($producto['nombre'])) ?>">
        <div class="flex items-start justify-between gap-3">
            <div class="min-w-0">
                <p class="font-semibold truncate"><?= e($producto['nombre']) ?></p>
                <p class="text-sm text-gray-500">
                    <?= $producto['precio'] ? '$' . number_format((float) $producto['precio'], 0, ',', '.') : 'Sin precio' ?>
                    · <?= count($producto['imagenes']) ?> <?= count($producto['imagenes']) === 1 ? 'imagen' : 'imágenes' ?>
                </p>
            </div>
            <form method="post" action="/admin/productos/<?= (int) $producto['id'] ?>/destacado" class="flex-shrink-0">
                <?= csrf_field() ?>
                <?php if (!empty($producto['destacado'])): ?>
                    <button type="submit" class="text-yellow-500 text-lg btn-touch" aria-label="Quitar de destacados"><i class="fas fa-star" aria-hidden="true"></i></button>
                <?php else: ?>
                    <button type="submit" class="text-gray-300 text-lg btn-touch" aria-label="Marcar como destacado"><i class="fas fa-star" aria-hidden="true"></i></button>
                <?php endif; ?>
            </form>
        </div>
        <div class="flex gap-4 mt-3 pt-3 border-t text-sm">
            <a href="/admin/productos/<?= (int) $producto['id'] ?>/editar" class="text-blue-600 font-medium btn-touch">Editar</a>
            <form method="post" action="/admin/productos/<?= (int) $producto['id'] ?>/eliminar"
                  class="js-confirm-delete-producto" data-nombre="<?= e($producto['nombre']) ?>">
                <?= csrf_field() ?>
                <button type="submit" class="text-red-600 font-medium btn-touch">Eliminar</button>
            </form>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Tabla: sm y superior — potenciada con DataTables (buscar/ordenar/paginar) -->
<div class="hidden sm:block bg-white rounded-xl shadow-sm p-4">
    <table id="tabla-productos" class="w-full text-sm">
        <thead class="bg-gray-50 text-left text-gray-500">
            <tr>
                <th class="px-4 py-3">Producto</th>
                <th class="px-4 py-3">Precio</th>
                <th class="px-4 py-3">Imágenes</th>
                <th class="px-4 py-3">Destacado</th>
                <th class="px-4 py-3" data-orderable="false">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            <?php foreach ($productos as $producto): ?>
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3"><?= e($producto['nombre']) ?></td>
                <td class="px-4 py-3" data-order="<?= (float) ($producto['precio'] ?? 0) ?>">
                    <?= $producto['precio'] ? '$' . number_format((float) $producto['precio'], 0, ',', '.') : '—' ?>
                </td>
                <td class="px-4 py-3"><?= count($producto['imagenes']) ?></td>
                <td class="px-4 py-3" data-order="<?= !empty($producto['destacado']) ? 1 : 0 ?>">
                    <form method="post" action="/admin/productos/<?= (int) $producto['id'] ?>/destacado">
                        <?= csrf_field() ?>
                        <?php if (!empty($producto['destacado'])): ?>
                            <button type="submit" class="inline-flex items-center gap-1 text-yellow-600 hover:text-yellow-700 font-medium">
                                <i class="fas fa-star" aria-hidden="true"></i> Destacado
                            </button>
                        <?php else: ?>
                            <button type="submit" class="inline-flex items-center gap-1 text-gray-500 hover:text-gray-700">
                                <i class="fas fa-star opacity-40" aria-hidden="true"></i> Marcar
                            </button>
                        <?php endif; ?>
                    </form>
                </td>
                <td class="px-4 py-3 text-right space-x-3 whitespace-nowrap">
                    <a href="/admin/productos/<?= (int) $producto['id'] ?>/editar" class="text-blue-600 hover:underline">Editar</a>
                    <form method="post" action="/admin/productos/<?= (int) $producto['id'] ?>/eliminar"
                          class="inline js-confirm-delete-producto" data-nombre="<?= e($producto['nombre']) ?>">
                        <?= csrf_field() ?>
                        <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>

<?php if (!empty($productos)): ?>
<!-- DataTables cargado solo en esta vista, desde cdnjs.cloudflare.com (único host externo
     permitido por el CSP del sitio; jsdelivr.net está bloqueado). El JS de inicialización vive
     en un archivo aparte porque el CSP bloquea script-src inline. -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-dt/3.1.2/css/dataTables.dataTables.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<!-- "datatables.net" es el motor (define $.fn.DataTable); "datatables.net-dt" (arriba/abajo) es
     solo el paquete de estilo/CSS — cargar únicamente el de estilo deja $.fn.DataTable sin
     definir y la tabla nunca se inicializa. -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net/3.1.2/dataTables.min.js"></script>
<script src="/assets/js/admin-productos.js"></script>
<?php endif; ?>
