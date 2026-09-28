<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= e($titulo ?? 'Tacos Capital') ?> - Tacos Capital</title>
    <meta name="description" content="<?= e($descripcion ?? '') ?>">
    <?php if (!empty($canonical)): ?>
    <link rel="canonical" href="<?= e($canonical) ?>">
    <?php endif; ?>

    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= e($titulo ?? '') ?> - Tacos Capital">
    <meta property="og:description" content="<?= e($descripcion ?? '') ?>">
    <meta property="og:url" content="<?= e($canonical ?? '') ?>">
    <meta property="og:image" content="<?= e($ogImage ?? Env::get('APP_URL') . '/assets/img/og-image.jpg') ?>">
    <meta name="twitter:card" content="summary_large_image">

    <link rel="icon" href="/assets/img/favicon.ico">
    <link rel="apple-touch-icon" href="/assets/img/apple-touch-icon.png">
    <link rel="stylesheet" href="/assets/css/app.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Store",
        "name": "Tacos Capital",
        "image": "<?= e(Env::get('APP_URL')) ?>/assets/img/logo.jpg",
        "url": "<?= e(Env::get('APP_URL')) ?>",
        "telephone": "+<?= e(Env::get('WHATSAPP_NUMERO')) ?>",
        "priceRange": "$$",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Diagonal 5 B # 71 B - 24",
            "addressLocality": "Bogotá",
            "addressCountry": "CO"
        },
        "openingHoursSpecification": [
            {
                "@type": "OpeningHoursSpecification",
                "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],
                "opens": "09:00",
                "closes": "18:00"
            },
            {
                "@type": "OpeningHoursSpecification",
                "dayOfWeek": "Saturday",
                "opens": "09:00",
                "closes": "14:00"
            }
        ],
        "sameAs": ["https://facebook.com/tacoscapital", "https://instagram.com/tacoscapital"]
    }
    </script>
</head>
<body class="min-h-screen flex flex-col bg-gray-50 text-gray-900 antialiased">

<header class="bg-gray-900 text-white sticky top-0 z-40 shadow-md">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <a href="/" class="text-xl font-bold tracking-tight">Tacos Capital</a>
            <div class="hidden md:flex items-center gap-6 text-sm font-medium">
                <a href="/" class="hover:text-blue-400 transition">Inicio</a>
                <a href="/productos" class="hover:text-blue-400 transition">Catálogo</a>
                <a href="/contacto" class="hover:text-blue-400 transition">Contacto</a>
            </div>
            <a href="<?= e(whatsapp_link()) ?>" target="_blank" rel="noopener"
               class="hidden md:inline-flex items-center gap-2 bg-green-600 hover:bg-green-500 px-4 py-2 rounded-lg text-sm font-semibold transition">
                <i class="fab fa-whatsapp" aria-hidden="true"></i> Contáctanos
            </a>
            <button id="menu-toggle" class="md:hidden p-2" aria-label="Abrir menú">
                <i class="fas fa-bars text-xl" aria-hidden="true"></i>
            </button>
        </div>
        <div id="mobile-menu" class="hidden md:hidden pb-4 flex flex-col gap-3 text-sm font-medium">
            <a href="/" class="hover:text-blue-400">Inicio</a>
            <a href="/productos" class="hover:text-blue-400">Catálogo</a>
            <a href="/contacto" class="hover:text-blue-400">Contacto</a>
            <a href="<?= e(whatsapp_link()) ?>" target="_blank" rel="noopener" class="text-green-400">
                <i class="fab fa-whatsapp" aria-hidden="true"></i> WhatsApp
            </a>
        </div>
    </nav>
</header>

<main class="flex-1">
    <?= $content ?>
</main>

<footer class="bg-gray-900 text-gray-300 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 grid grid-cols-1 sm:grid-cols-3 gap-8 text-sm">
        <div>
            <h3 class="text-white font-bold mb-3">Tacos Capital</h3>
            <p>Especialistas en tacos de billar de alta calidad. Venta, reparación y personalización.</p>
        </div>
        <div>
            <h3 class="text-white font-bold mb-3">Enlaces</h3>
            <ul class="space-y-1">
                <li><a href="/productos" class="hover:text-white">Catálogo</a></li>
                <li><a href="/contacto" class="hover:text-white">Contacto</a></li>
            </ul>
        </div>
        <div>
            <h3 class="text-white font-bold mb-3">Contacto</h3>
            <p class="mb-3"><i class="fas fa-phone mr-2" aria-hidden="true"></i>+<?= e(Env::get('WHATSAPP_NUMERO')) ?></p>
            <p class="mb-3"><i class="fas fa-map-marker-alt mr-2" aria-hidden="true"></i>Diagonal 5 B # 71 B - 24, Bogotá</p>
            <div class="flex gap-4 text-xl">
                <a href="https://facebook.com/tacoscapital" target="_blank" rel="noopener" class="hover:text-white" aria-label="Facebook">
                    <i class="fab fa-facebook-square" aria-hidden="true"></i>
                </a>
                <a href="https://instagram.com/tacoscapital" target="_blank" rel="noopener" class="hover:text-white" aria-label="Instagram">
                    <i class="fab fa-instagram" aria-hidden="true"></i>
                </a>
                <a href="<?= e(whatsapp_link()) ?>" target="_blank" rel="noopener" class="hover:text-white" aria-label="WhatsApp">
                    <i class="fab fa-whatsapp" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="border-t border-gray-800 text-center text-xs py-4">
        &copy; <?= date('Y') ?> Tacos Capital.
        <a href="/admin/login" class="text-gray-500 hover:text-white">Administración</a>
    </div>
</footer>

<?php if (empty($ocultarWhatsappFlotante)): ?>
<a href="<?= e(whatsapp_link()) ?>" target="_blank" rel="noopener"
   class="md:hidden fixed bottom-5 right-5 z-50 w-14 h-14 bg-green-600 rounded-full shadow-lg flex items-center justify-center">
    <i class="fab fa-whatsapp text-white text-2xl" aria-hidden="true"></i>
</a>
<?php endif; ?>

<script src="/assets/js/menu.js"></script>
<script src="/assets/js/galeria.js"></script>
<script src="/assets/js/catalogo.js"></script>
</body>
</html>
