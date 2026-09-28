<?php /** @var array $producto */ ?>
<?php $nombreTitulo = mb_convert_case($producto['nombre'], MB_CASE_TITLE, 'UTF-8'); ?>
<a href="/producto/<?= e($producto['slug']) ?>"
   class="group bg-white rounded-xl shadow-sm hover:shadow-lg transition overflow-hidden flex flex-col">
    <div class="aspect-square bg-gray-100 overflow-hidden">
        <?php if (!empty($producto['imagenes'])): ?>
            <img src="/<?= e($producto['imagenes'][0]['url_thumb'] ?? $producto['imagenes'][0]['url']) ?>"
                 alt="<?= e($nombreTitulo) ?> - taco de billar"
                 loading="lazy"
                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
        <?php else: ?>
            <div class="w-full h-full flex items-center justify-center text-gray-400">
                <i class="fas fa-image text-3xl" aria-hidden="true"></i>
            </div>
        <?php endif; ?>
    </div>
    <div class="p-4 flex-1 flex flex-col">
        <h3 class="font-semibold text-sm sm:text-base mb-1 line-clamp-2"><?= e($nombreTitulo) ?></h3>
        <?php if (!empty($producto['precio'])): ?>
            <p class="text-blue-600 font-bold mt-auto">$<?= number_format((float) $producto['precio'], 0, ',', '.') ?></p>
        <?php endif; ?>
    </div>
</a>
