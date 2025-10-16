<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? 'Tacos Capital - Tacos de Billar Profesionales' ?></title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="<?= $descripcion ?? 'Tacos Capital - Especialistas en tacos de billar de alta calidad. Venta, reparación y personalización de tacos.' ?>">
    <meta name="keywords" content="tacos de billar, tacos profesionales, virolas, suelas, reparación de tacos, personalización de tacos, billar, pool, accesorios de billar">
    <meta name="author" content="Tacos Capital">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://tacoscapital.online/">
    <meta property="og:title" content="<?= $titulo ?? 'Tacos Capital - Tacos de Billar Profesionales' ?>">
    <meta property="og:description" content="<?= $descripcion ?? 'Tacos Capital - Especialistas en tacos de billar de alta calidad.' ?>">
    <meta property="og:image" content="https://tacoscapital.online/assets/img/og-image.jpg">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://tacoscapital.online/">
    <meta property="twitter:title" content="<?= $titulo ?? 'Tacos Capital - Tacos de Billar Profesionales' ?>">
    <meta property="twitter:description" content="<?= $descripcion ?? 'Tacos Capital - Especialistas en tacos de billar de alta calidad.' ?>">
    <meta property="twitter:image" content="https://tacoscapital.online/assets/img/og-image.jpg">
    
    <!-- Favicon -->
    <link rel="icon" href="/icons/favicon.ico">
    <link rel="apple-touch-icon" href="/icons/apple-touch-icon.png">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="navbar fixed w-full z-50" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="/" class="flex items-center hover-lift">
                            <img class="h-8 w-auto" src="/assets/img/logo.png" alt="Tacos Capital" onerror="this.style.display='none'">
                            <span class="ml-2 text-xl font-bold text-gradient">Tacos Capital</span>
                        </a>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-4">
                            <a href="/" class="px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-white hover:bg-opacity-10 transition-all duration-300">Inicio</a>
                            <a href="#productos" class="px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-white hover:bg-opacity-10 transition-all duration-300">Productos</a>
                            <a href="#servicios" class="px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-white hover:bg-opacity-10 transition-all duration-300">Servicios</a>
                            <a href="#contacto" class="px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-white hover:bg-opacity-10 transition-all duration-300">Contacto</a>
                        </div>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="ml-4 flex items-center md:ml-6">
                        <a href="https://wa.me/573012345678" target="_blank" class="btn btn-success whatsapp-pulse">
                            <i class="fab fa-whatsapp mr-2"></i> Contáctanos
                        </a>
                    </div>
                </div>
                <div class="-mr-2 flex md:hidden">
                    <button type="button" class="bg-gray-800 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white transition-all duration-300" id="mobile-menu-button">
                        <span class="sr-only">Abrir menú principal</span>
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
            
            <!-- Mobile menu -->
            <div class="hidden md:hidden" id="mobile-menu">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 glass-effect">
                    <a href="/" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-white hover:bg-opacity-10 transition-all duration-300">Inicio</a>
                    <a href="#productos" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-white hover:bg-opacity-10 transition-all duration-300">Productos</a>
                    <a href="#servicios" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-white hover:bg-opacity-10 transition-all duration-300">Servicios</a>
                    <a href="#contacto" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-white hover:bg-opacity-10 transition-all duration-300">Contacto</a>
                    <a href="https://wa.me/573012345678" target="_blank" class="flex items-center px-3 py-2 rounded-md text-base font-medium text-white hover:bg-white hover:bg-opacity-10 transition-all duration-300">
                        <i class="fab fa-whatsapp mr-2"></i> Contáctanos
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section relative min-h-screen flex items-center justify-center overflow-hidden">
        <img src="/assets/img/banner_tacos_capital.png" alt="Tacos de billar" class="hero-bg absolute inset-0 w-full h-full object-cover">
        <div class="hero-overlay absolute inset-0 bg-black bg-opacity-40"></div>
        <div class="hero-content relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center fade-in">
            <h1 class="hero-title text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold text-white mb-4 sm:mb-6">
                <span class="text-gradient">Tacos Capital</span>
            </h1>
            <p class="hero-subtitle text-lg sm:text-xl md:text-2xl text-gray-200 mb-6 sm:mb-8 max-w-3xl mx-auto px-4">
                Los mejores tacos de billar para jugadores de todos los niveles
            </p>
            <div class="flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-4 px-4">
                <a href="#productos" class="btn btn-primary scale-in w-full sm:w-auto">
                    <i class="fas fa-eye mr-2"></i>
                    Ver Productos
                </a>
                <a href="#servicios" class="btn btn-secondary scale-in w-full sm:w-auto">
                    <i class="fas fa-tools mr-2"></i>
                    Nuestros Servicios
                </a>
            </div>
        </div>
        <!-- Scroll indicator -->
        <div class="absolute bottom-4 sm:bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <i class="fas fa-chevron-down text-white text-xl sm:text-2xl"></i>
        </div>
    </section>

    <!-- Features Section -->
    <section class="section bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="section-title slide-up">¿Por qué elegirnos?</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                <div class="text-center p-4 sm:p-6 bg-gray-50 rounded-lg shadow-sm hover:shadow-md transition duration-300 fade-in" style="animation-delay: 0.1s;">
                    <div class="inline-flex items-center justify-center w-12 h-12 sm:w-16 sm:h-16 bg-blue-100 text-blue-600 rounded-full mb-3 sm:mb-4">
                        <i class="fas fa-medal text-xl sm:text-2xl"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold mb-2">Calidad Premium</h3>
                    <p class="text-sm sm:text-base text-gray-600">Utilizamos los mejores materiales para garantizar durabilidad y rendimiento en cada taco.</p>
                </div>
                
                <div class="text-center p-4 sm:p-6 bg-gray-50 rounded-lg shadow-sm hover:shadow-md transition duration-300 fade-in" style="animation-delay: 0.2s;">
                    <div class="inline-flex items-center justify-center w-12 h-12 sm:w-16 sm:h-16 bg-blue-100 text-blue-600 rounded-full mb-3 sm:mb-4">
                        <i class="fas fa-tools text-xl sm:text-2xl"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold mb-2">Servicio Técnico</h3>
                    <p class="text-sm sm:text-base text-gray-600">Ofrecemos reparación y mantenimiento profesional para mantener tus tacos en óptimas condiciones.</p>
                </div>
                
                <div class="text-center p-4 sm:p-6 bg-gray-50 rounded-lg shadow-sm hover:shadow-md transition duration-300 fade-in sm:col-span-2 lg:col-span-1" style="animation-delay: 0.3s;">
                    <div class="inline-flex items-center justify-center w-12 h-12 sm:w-16 sm:h-16 bg-blue-100 text-blue-600 rounded-full mb-3 sm:mb-4">
                        <i class="fas fa-paint-brush text-xl sm:text-2xl"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold mb-2">Personalización</h3>
                    <p class="text-sm sm:text-base text-gray-600">Creamos tacos a medida según tus preferencias, estilo de juego y especificaciones técnicas.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="servicios" class="section bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="section-title slide-up">Nuestros Servicios</h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Servicio 1: Cambio de Virolas -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col md:flex-row fade-in" style="animation-delay: 0.1s;">
                    <div class="md:w-2/5">
                        <img src="/assets/img/servicios/cambio_de_casquillos.jpg" alt="Cambio de virolas" class="w-full h-full object-cover">
                    </div>
                    <div class="md:w-3/5 p-6">
                        <h3 class="text-2xl font-bold mb-3">Cambio de Virolas</h3>
                        <p class="text-gray-600 mb-4">Reemplazamos virolas desgastadas o dañadas por nuevas de alta calidad. Disponemos de diferentes materiales como fibra, marfil sintético y metal.</p>
                        <ul class="mb-4 space-y-2">
                            <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Virolas de fibra</li>
                            <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Virolas de marfil sintético</li>
                            <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Virolas metálicas</li>
                        </ul>
                        <a href="https://wa.me/573188763377" 
                           target="_blank" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-300">
                            <i class="fab fa-whatsapp mr-2"></i> Consultar servicio
                        </a>
                    </div>
                </div>
                
                <!-- Servicio 2: Personalización -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col md:flex-row fade-in" style="animation-delay: 0.2s;">
                    <div class="md:w-2/5">
                        <img src="/assets/img/servicios/marcacion_laser_v2.jpg" alt="Personalización de tacos" class="w-full h-full object-cover">
                    </div>
                    <div class="md:w-3/5 p-6">
                        <h3 class="text-2xl font-bold mb-3">Personalización</h3>
                        <p class="text-gray-600 mb-4">Creamos tacos únicos según tus especificaciones. Elige materiales, diseños y características técnicas para un taco a tu medida.</p>
                        <ul class="mb-4 space-y-2">
                            <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Grabado personalizado</li>
                            <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Selección de maderas exóticas</li>
                            <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Diseños exclusivos</li>
                        </ul>
                        <a href="https://wa.me/573188763377" 
                           target="_blank" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-300">
                            <i class="fab fa-whatsapp mr-2"></i> Consultar servicio
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Productos Destacados -->
    <section id="productos" class="section bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="section-title slide-up">Productos Destacados</h2>
                <p class="section-subtitle slide-up">Descubre nuestra selección de tacos de billar de alta calidad</p>
            </div>
            
            <?php if (empty($productos)): ?>
                <div class="text-center py-12">
                    <i class="fas fa-box-open text-gray-400 text-6xl mb-4"></i>
                    <p class="text-gray-600 text-lg">No hay productos disponibles en este momento.</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                    <?php foreach ($productos as $index => $producto): ?>
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 fade-in" style="animation-delay: <?= $index * 0.1 ?>s;">
                            <div class="relative h-48 sm:h-56 lg:h-64 overflow-hidden">
                                <?php if (!empty($producto['portada'])): ?>
                                    <img src="<?= $producto['portada'] ?>" 
                                         alt="<?= htmlspecialchars($producto['nombre']) ?>" 
                                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                         loading="lazy">
                                <?php else: ?>
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400 text-3xl sm:text-4xl"></i>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($producto['destacado']): ?>
                                    <div class="absolute top-2 left-2 bg-blue-600 text-white px-2 py-1 rounded text-xs font-semibold">
                                        Destacado
                                    </div>
                                <?php endif; ?>
                                
                                <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-40 transition-all duration-300 flex items-center justify-center opacity-0 hover:opacity-100">
                                    <a href="/productos/<?= $producto['slug'] ?>" 
                                       class="btn btn-primary btn-sm transform scale-90 hover:scale-100 transition-transform duration-200">
                                        <i class="fas fa-eye mr-2"></i>
                                        Ver detalles
                                    </a>
                                </div>
                            </div>
                            
                            <div class="p-4 sm:p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2"><?= htmlspecialchars($producto['nombre']) ?></h3>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3"><?= htmlspecialchars($producto['descripcion_corta']) ?></p>
                                
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                    <span class="text-xl sm:text-2xl font-bold text-gradient">
                                        $<?= $producto['precio_formateado'] ?>
                                    </span>
                                    <div class="flex space-x-2">
                                        <a href="https://wa.me/573188763377?text=Hola, me interesa el producto: <?= urlencode($producto['nombre']) ?>" 
                                           target="_blank"
                                           class="btn btn-success btn-sm hover-lift flex-1 sm:flex-none">
                                            <i class="fab fa-whatsapp mr-1 sm:mr-0"></i>
                                            <span class="sm:hidden">WhatsApp</span>
                                        </a>
                                        <a href="/productos/<?= $producto['slug'] ?>" 
                                           class="btn btn-secondary btn-sm hover-lift flex-1 sm:flex-none">
                                            <i class="fas fa-info-circle mr-1 sm:mr-0"></i>
                                            <span class="sm:hidden">Detalles</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="text-center mt-12">
                    <a href="/productos" class="btn btn-primary btn-lg hover-lift">
                        <i class="fas fa-th-large mr-2"></i>
                        Ver todos los productos
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Video Section -->
    <section class="section bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="section-title slide-up">Aprende con Nosotros</h2>
                <p class="section-subtitle slide-up max-w-3xl mx-auto">Mira nuestro video de la competencia</p>
            </div>
            
            <div class="max-w-4xl mx-auto">
                <div class="video-container scale-in">
                    <iframe 
                        width="100%" 
                        height="450" 
                        src="https://www.youtube.com/embed/oSOma1WXhLA?si=QMGIxFRGyvvlhPwd" 
                        title="YouTube video player" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contacto" class="section bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="section-title slide-up">Contáctanos</h2>
                <p class="section-subtitle slide-up">Estamos aquí para ayudarte con tus necesidades de billar</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                <div class="card-contact fade-in sm:col-span-2 lg:col-span-1" style="animation-delay: 0.1s;">
                    <div class="contact-icon bg-green-100 whatsapp-pulse">
                        <i class="fab fa-whatsapp text-green-600 text-xl sm:text-2xl"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold mb-2">WhatsApp</h3>
                    <p class="text-sm sm:text-base text-gray-600 mb-4">Chatea con nosotros directamente</p>
                    <a href="https://wa.me/573012345678" 
                       target="_blank"
                       class="btn btn-success btn-sm hover-lift text-sm sm:text-base">
                        +57 301 234 5678
                    </a>
                </div>
                
                <div class="card-contact fade-in" style="animation-delay: 0.2s;">
                    <div class="contact-icon bg-blue-100">
                        <i class="fas fa-envelope text-blue-600 text-xl sm:text-2xl"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold mb-2">Email</h3>
                    <p class="text-sm sm:text-base text-gray-600 mb-4">Envíanos un correo</p>
                    <a href="mailto:info@tacoscapital.com" 
                       class="text-blue-600 hover:text-blue-700 font-medium hover-lift text-sm sm:text-base break-all">
                        info@tacoscapital.com
                    </a>
                </div>
                
                <div class="card-contact fade-in" style="animation-delay: 0.3s;">
                    <div class="contact-icon bg-purple-100">
                        <i class="fas fa-map-marker-alt text-purple-600 text-xl sm:text-2xl"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold mb-2">Ubicación</h3>
                    <p class="text-sm sm:text-base text-gray-600 mb-4">Visítanos en nuestro taller</p>
                    <p class="text-purple-600 font-medium text-sm sm:text-base">Bogotá, Colombia</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Mapa de Ubicación -->
    <section class="section bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="section-title slide-up">Nuestra Ubicación</h2>
                <p class="section-subtitle slide-up max-w-3xl mx-auto">Visítanos en nuestra tienda física para conocer nuestros productos</p>
            </div>
            
            <div class="max-w-4xl mx-auto">
                <div class="rounded-lg overflow-hidden shadow-xl fade-in">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d994.2015918253761!2d-74.1359348303677!3d4.628608136440334!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3f9d003fd34e39%3A0x3de784bb9fedb59e!2sTACOS%20CAPITAL!5e0!3m2!1ses!2sco!4v1743842935182!5m2!1ses!2sco" 
                    width="100%" height="450" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                
                <div class="mt-8 bg-white p-6 rounded-lg shadow-md fade-in" style="animation-delay: 0.2s;">
                    <div class="flex items-start mb-4">
                        <i class="fas fa-map-marker-alt text-blue-600 text-2xl mt-1 mr-4"></i>
                        <div>
                            <h3 class="text-lg font-semibold mb-1">Dirección</h3>
                            <p class="text-gray-600">Agenda tu visita</p>
                            <p class="text-gray-600">Diagonal 5 B # 71 B - 24 , Bogotá, Colombia</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start mb-4">
                        <i class="fas fa-clock text-blue-600 text-2xl mt-1 mr-4"></i>
                        <div>
                            <h3 class="text-lg font-semibold mb-1">Horario de Atención</h3>
                            <p class="text-gray-600">Agenda tu visita antes de llegar</p>
                            <p class="text-gray-600">Lunes a Viernes: 9:00 AM - 6:00 PM</p>
                            <p class="text-gray-600">Sábados: 9:00 AM - 2:00 PM</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <i class="fas fa-phone-alt text-blue-600 text-2xl mt-1 mr-4"></i>
                        <div>
                            <h3 class="text-lg font-semibold mb-1">Teléfono</h3>
                            <p class="text-gray-600">Agenda tu visita</p>
                            <p class="text-gray-600">+57 3188763377</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Nuestra Ubicación -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4 fade-in">Nuestra Ubicación</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto fade-in" style="animation-delay: 0.2s;">
                    Visítanos en nuestro taller especializado
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Mapa -->
                <div class="fade-in" style="animation-delay: 0.3s;">
                    <div class="rounded-lg overflow-hidden shadow-lg h-96">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3976.8234567890123!2d-74.0123456789!3d4.6123456789!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNMKwMzYnNDQuNCJOIDc0wrAwMCc0NC40Ilc!5e0!3m2!1ses!2sco!4v1234567890123!5m2!1ses!2sco"
                            width="100%" 
                            height="100%" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>

                <!-- Información de contacto -->
                <div class="fade-in" style="animation-delay: 0.4s;">
                    <div class="bg-white p-8 rounded-lg shadow-lg">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Información de Contacto</h3>
                        
                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-map-marker-alt text-blue-600 text-xl mt-1"></i>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-semibold text-gray-900">Dirección</h4>
                                    <p class="text-gray-600">Calle 123 #45-67<br>Bogotá, Colombia</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-clock text-blue-600 text-xl mt-1"></i>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-semibold text-gray-900">Horarios de Atención</h4>
                                    <div class="text-gray-600">
                                        <p>Lunes a Viernes: 8:00 AM - 6:00 PM</p>
                                        <p>Sábados: 9:00 AM - 4:00 PM</p>
                                        <p>Domingos: Cerrado</p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-phone text-blue-600 text-xl mt-1"></i>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-semibold text-gray-900">Teléfono</h4>
                                    <p class="text-gray-600">+57 318 876 3377</p>
                                </div>
                            </div>

                            <div class="pt-4">
                                <a href="https://wa.me/573188763377?text=Hola,%20me%20interesa%20conocer%20más%20sobre%20sus%20servicios" 
                                   target="_blank"
                                   class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors duration-300">
                                    <i class="fab fa-whatsapp mr-2 text-xl"></i>
                                    Contactar por WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2 fade-in" style="animation-delay: 0.1s;">
                    <h3 class="text-xl font-bold mb-4 text-gradient">Tacos Capital</h3>
                    <p class="text-gray-300 mb-4">
                        Especialistas en tacos de billar de alta calidad. Más de 10 años de experiencia 
                        en venta, reparación y personalización de tacos profesionales.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-300 hover:text-white transition duration-300 hover-lift">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white transition duration-300 hover-lift">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="https://wa.me/573012345678" target="_blank" class="text-gray-300 hover:text-white transition duration-300 hover-lift whatsapp-pulse">
                            <i class="fab fa-whatsapp text-xl"></i>
                        </a>
                    </div>
                </div>
                
                <div class="fade-in" style="animation-delay: 0.2s;">
                    <h4 class="text-lg font-semibold mb-4">Enlaces</h4>
                    <ul class="space-y-2">
                        <li><a href="/" class="text-gray-300 hover:text-white transition duration-300 hover-lift">Inicio</a></li>
                        <li><a href="/productos" class="text-gray-300 hover:text-white transition duration-300 hover-lift">Productos</a></li>
                        <li><a href="#servicios" class="text-gray-300 hover:text-white transition duration-300 hover-lift">Servicios</a></li>
                        <li><a href="#contacto" class="text-gray-300 hover:text-white transition duration-300 hover-lift">Contacto</a></li>
                    </ul>
                </div>
                
                <div class="fade-in" style="animation-delay: 0.3s;">
                    <h4 class="text-lg font-semibold mb-4">Contacto</h4>
                    <ul class="space-y-2 text-gray-300 mb-4">
                        <li><i class="fas fa-phone mr-2"></i> +57 301 234 5678</li>
                        <li><i class="fas fa-envelope mr-2"></i> info@tacoscapital.com</li>
                        <li><i class="fas fa-map-marker-alt mr-2"></i> Bogotá, Colombia</li>
                    </ul>
                    <a href="https://wa.me/573012345678" target="_blank" class="btn btn-success btn-sm whatsapp-pulse">
                        <i class="fab fa-whatsapp mr-2"></i>
                        Contactar ahora
                    </a>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p class="text-gray-300">
                    &copy; <?= date('Y') ?> Tacos Capital. Todos los derechos reservados.
                </p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }
            
            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                        
                        // Close mobile menu if open
                        if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                            mobileMenu.classList.add('hidden');
                        }
                    }
                });
            });

            // Intersection Observer for animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate');
                    }
                });
            }, observerOptions);

            // Observe all animated elements
            const animatedElements = document.querySelectorAll('.fade-in, .slide-up, .scale-in');
            animatedElements.forEach(el => observer.observe(el));
        });

        // Add to cart functionality
        function addToCart(productId) {
            // Show loading state
            const button = event.target.closest('button');
            const originalContent = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            button.disabled = true;

            // Simulate API call
            fetch('/api/carrito/agregar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    producto_id: productId,
                    cantidad: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    button.innerHTML = '<i class="fas fa-check"></i>';
                    button.classList.remove('btn-primary');
                    button.classList.add('btn-success');
                    
                    // Show notification
                    showNotification('Producto agregado al carrito', 'success');
                    
                    // Reset button after 2 seconds
                    setTimeout(() => {
                        button.innerHTML = originalContent;
                        button.classList.remove('btn-success');
                        button.classList.add('btn-primary');
                        button.disabled = false;
                    }, 2000);
                } else {
                    throw new Error(data.message || 'Error al agregar al carrito');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                button.innerHTML = originalContent;
                button.disabled = false;
                showNotification('Error al agregar al carrito', 'error');
            });
        }

        // Notification system
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300 ${
                type === 'success' ? 'bg-green-500 text-white' :
                type === 'error' ? 'bg-red-500 text-white' :
                'bg-blue-500 text-white'
            }`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'exclamation-triangle' : 'info'} mr-2"></i>
                    <span>${message}</span>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);
            
            // Remove after 3 seconds
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }

        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 100) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Lazy loading for images
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }

        // Parallax effect for hero section
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const parallax = document.querySelector('.hero-bg');
            if (parallax) {
                const speed = scrolled * 0.5;
                parallax.style.transform = `translateY(${speed}px)`;
            }
        });
    </script>
</body>
</html>