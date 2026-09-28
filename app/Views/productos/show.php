<?php /** @var array $producto */ ?>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Product",
    "name": <?= json_encode($titulo, JSON_UNESCAPED_UNICODE) ?>,
    "description": <?= json_encode($descripcion, JSON_UNESCAPED_UNICODE) ?>,
    <?php if (!empty($producto['imagenes'])): ?>
    "image": <?= json_encode(array_map(
        fn($img) => Env::get('APP_URL') . '/' . $img['url'],
        $producto['imagenes']
    ), JSON_UNESCAPED_UNICODE) ?>,
    <?php endif; ?>
    "offers": {
        "@type": "Offer",
        "url": <?= json_encode(Env::get('APP_URL') . '/producto/' . $producto['slug']) ?>,
        "priceCurrency": "COP",
        <?php if (!empty($producto['precio'])): ?>
        "price": "<?= (float) $producto['precio'] ?>",
        <?php endif; ?>
        "availability": "https://schema.org/InStock"
    }
}
</script>
<section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 pb-24 sm:pb-10">
    <nav class="text-sm text-gray-500 mb-6">
        <a href="/" class="hover:text-blue-600">Inicio</a> /
        <a href="/productos" class="hover:text-blue-600">Catálogo</a> /
        <span class="text-gray-800"><?= e($titulo) ?></span>
    </nav>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
        <div>
            <?php if (!empty($producto['imagenes'])): ?>
                <div id="galeria" class="relative aspect-square bg-gray-100 rounded-xl overflow-hidden mb-3">
                    <?php foreach ($producto['imagenes'] as $indice => $img): ?>
                        <img src="/<?= e($img['url']) ?>" alt="<?= e($titulo) ?> - taco de billar en Bogotá"
                             data-galeria-imagen data-indice="<?= $indice ?>"
                             class="absolute inset-0 w-full h-full object-cover transition-opacity duration-200 <?= $indice === 0 ? 'opacity-100' : 'opacity-0 pointer-events-none' ?>">
                    <?php endforeach; ?>

                    <?php if (count($producto['imagenes']) > 1): ?>
                        <button type="button" data-galeria-prev aria-label="Foto anterior"
                                class="absolute left-2 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-white/80 hover:bg-white flex items-center justify-center shadow">
                            <i class="fas fa-chevron-left" aria-hidden="true"></i>
                        </button>
                        <button type="button" data-galeria-next aria-label="Foto siguiente"
                                class="absolute right-2 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-white/80 hover:bg-white flex items-center justify-center shadow">
                            <i class="fas fa-chevron-right" aria-hidden="true"></i>
                        </button>
                    <?php endif; ?>
                </div>

                <?php if (count($producto['imagenes']) > 1): ?>
                <div class="grid grid-cols-4 gap-2">
                    <?php foreach ($producto['imagenes'] as $indice => $img): ?>
                        <button type="button" data-galeria-thumb data-indice="<?= $indice ?>"
                                class="aspect-square bg-gray-100 rounded-lg overflow-hidden border-2 <?= $indice === 0 ? 'border-blue-500' : 'border-transparent' ?> hover:border-blue-500">
                            <img src="/<?= e($img['url_thumb'] ?? $img['url']) ?>" alt="" class="w-full h-full object-cover">
                        </button>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="aspect-square bg-gray-100 rounded-xl flex items-center justify-center text-gray-400">
                    <i class="fas fa-image text-5xl" aria-hidden="true"></i>
                </div>
            <?php endif; ?>
        </div>

        <div>
            <h1 class="text-2xl sm:text-3xl font-bold mb-3"><?= e($titulo) ?></h1>
            <?php if (!empty($producto['precio'])): ?>
                <p class="text-2xl font-bold text-blue-600 mb-6">
                    $<?= number_format((float) $producto['precio'], 0, ',', '.') ?>
                </p>
            <?php endif; ?>
            <p class="text-gray-700 mb-8 whitespace-pre-line"><?= e($producto['descripcion']) ?></p>

            <a href="<?= e(whatsapp_link('Hola, estoy interesado en: ' . $titulo)) ?>"
               target="_blank" rel="noopener"
               class="hidden sm:inline-flex items-center gap-2 bg-green-600 hover:bg-green-500 text-white font-semibold px-6 py-3 rounded-lg justify-center transition">
                <i class="fab fa-whatsapp text-xl" aria-hidden="true"></i> Consultar por WhatsApp
            </a>
        </div>
    </div>
</section>

<div class="sm:hidden fixed bottom-0 inset-x-0 bg-white border-t p-3 z-40">
    <a href="<?= e(whatsapp_link('Hola, estoy interesado en: ' . $titulo)) ?>"
       target="_blank" rel="noopener"
       class="flex items-center justify-center gap-2 bg-green-600 text-white font-semibold py-3 rounded-lg">
        <i class="fab fa-whatsapp text-xl" aria-hidden="true"></i> Consultar por WhatsApp
    </a>
</div>
