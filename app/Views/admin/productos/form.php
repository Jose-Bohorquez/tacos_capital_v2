<?php /** @var array|null $producto */ ?>
<div class="mb-6">
    <a href="/admin/productos" class="text-sm text-gray-500 hover:text-gray-700">&larr; Volver a productos</a>
    <h1 class="text-xl sm:text-2xl font-bold mt-1"><?= $producto ? 'Editar producto' : 'Agregar producto' ?></h1>
</div>

<?php if ($producto && !empty($producto['imagenes'])): ?>
<div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 max-w-2xl mb-6">
    <h2 class="text-sm font-medium mb-1">Imágenes actuales (<?= count($producto['imagenes']) ?>)</h2>
    <p class="text-xs text-gray-500 mb-3">La imagen "Principal" es la que se muestra primero en el catálogo y al compartir el producto.</p>
    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
        <?php foreach ($producto['imagenes'] as $img): ?>
            <?php $esWebp = str_ends_with($img['url'], '.webp'); ?>
            <div class="border rounded-lg overflow-hidden">
                <div class="relative">
                    <img src="/<?= e($img['url_thumb'] ?? $img['url']) ?>" class="aspect-square w-full object-cover">
                    <?php if (!empty($img['es_principal'])): ?>
                        <span class="absolute top-1 left-1 bg-blue-600 text-white text-[10px] px-1.5 py-0.5 rounded">Principal</span>
                    <?php endif; ?>
                    <?php if (!$esWebp): ?>
                        <span class="absolute top-1 right-1 bg-yellow-500 text-white text-[10px] px-1.5 py-0.5 rounded" title="Formato original, no optimizado">
                            <?= strtoupper(pathinfo($img['url'], PATHINFO_EXTENSION)) ?>
                        </span>
                    <?php endif; ?>
                    <form method="post"
                          action="/admin/productos/<?= (int) $producto['id'] ?>/imagenes/<?= (int) $img['id'] ?>/eliminar"
                          class="absolute bottom-1 right-1 js-confirm-delete-imagen">
                        <?= csrf_field() ?>
                        <button type="submit" aria-label="Eliminar imagen"
                                class="w-6 h-6 rounded-full bg-red-600 hover:bg-red-500 text-white text-xs flex items-center justify-center shadow">
                            <i class="fas fa-xmark" aria-hidden="true"></i>
                        </button>
                    </form>
                </div>
                <div class="flex text-xs divide-x border-t">
                    <?php if (empty($img['es_principal'])): ?>
                        <form method="post" action="/admin/productos/<?= (int) $producto['id'] ?>/imagenes/<?= (int) $img['id'] ?>/principal" class="flex-1">
                            <?= csrf_field() ?>
                            <button type="submit" class="w-full py-1.5 text-gray-600 hover:bg-gray-50" title="Hacer imagen principal">
                                <i class="fas fa-star" aria-hidden="true"></i> Principal
                            </button>
                        </form>
                    <?php else: ?>
                        <span class="flex-1 py-1.5 text-center text-gray-300">
                            <i class="fas fa-star" aria-hidden="true"></i> Principal
                        </span>
                    <?php endif; ?>
                    <?php if (!$esWebp): ?>
                        <form method="post" action="/admin/productos/<?= (int) $producto['id'] ?>/imagenes/<?= (int) $img['id'] ?>/optimizar" class="flex-1">
                            <?= csrf_field() ?>
                            <button type="submit" class="w-full py-1.5 text-gray-600 hover:bg-gray-50" title="Convertir a WebP (más rápido y liviano)">
                                <i class="fas fa-bolt" aria-hidden="true"></i> WebP
                            </button>
                        </form>
                    <?php else: ?>
                        <span class="flex-1 py-1.5 text-center text-green-600" title="Ya optimizada">
                            <i class="fas fa-check" aria-hidden="true"></i> WebP
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<form method="post"
      action="<?= $producto ? '/admin/productos/' . (int) $producto['id'] : '/admin/productos' ?>"
      enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm p-4 sm:p-6 max-w-2xl space-y-5">
    <?= csrf_field() ?>

    <div>
        <label class="block text-sm font-medium mb-1">Nombre</label>
        <input type="text" name="nombre" required value="<?= e($producto['nombre'] ?? '') ?>"
               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-base focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Precio (COP)</label>
        <input type="number" step="1" inputmode="numeric" name="precio" value="<?= e((string) ($producto['precio'] ?? '')) ?>"
               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-base focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Categoría</label>
        <select name="category_id"
                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-base focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Sin categoría</option>
            <?php foreach ($categorias as $categoria): ?>
                <option value="<?= (int) $categoria['id'] ?>" <?= (int) ($producto['category_id'] ?? 0) === (int) $categoria['id'] ? 'selected' : '' ?>>
                    <?= e($categoria['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <label for="destacado" class="flex items-center gap-3 bg-yellow-50 border border-yellow-200 rounded-lg px-4 py-3 cursor-pointer">
        <input type="checkbox" id="destacado" name="destacado" value="1"
               <?= !empty($producto['destacado']) ? 'checked' : '' ?>
               class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 flex-shrink-0">
        <span class="text-sm font-medium">
            <i class="fas fa-star text-yellow-500 mr-1" aria-hidden="true"></i>
            Mostrar en "Productos destacados" del inicio
        </span>
    </label>

    <div>
        <label class="block text-sm font-medium mb-1">Descripción</label>
        <textarea name="descripcion" rows="5"
                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-base focus:outline-none focus:ring-2 focus:ring-blue-500"><?= e($producto['descripcion'] ?? '') ?></textarea>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">
            <?= $producto && !empty($producto['imagenes']) ? 'Agregar más imágenes' : 'Imágenes' ?>
            (JPG, PNG, WEBP o GIF)
        </label>
        <input type="file" name="imagenes[]" multiple accept="image/jpeg,image/png,image/webp,image/gif"
               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:bg-blue-50 file:text-blue-700 file:text-sm">
        <p class="text-xs text-gray-500 mt-1">Las imágenes nuevas se optimizan automáticamente a WebP (más livianas y rápidas).</p>
    </div>

    <div class="flex flex-col-reverse sm:flex-row sm:items-center gap-3 pt-2">
        <a href="/admin/productos" class="text-gray-600 text-center sm:text-left">Cancelar</a>
        <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white font-semibold px-6 py-2.5 rounded-lg sm:ml-auto sm:order-2">
            Guardar
        </button>
    </div>
</form>
