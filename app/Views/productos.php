<?php $this->layout('layout', ['title' => 'Productos - Tacos Capital', 'description' => 'Descubre nuestra amplia selección de tacos de billar profesionales']) ?>

<!-- Banner Principal Hero -->
<section class="relative h-96 overflow-hidden">
    <div class="absolute inset-0">
        <img src="/assets/img/banner_tacos_capital.svg" 
             alt="Tacos Capital - Tacos de Billar Profesionales" 
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-black/30 to-transparent"></div>
    </div>
    
    <!-- Contenido superpuesto -->
    <div class="relative z-10 h-full flex items-center">
        <div class="container mx-auto px-4">
            <div class="max-w-2xl">
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-4">
                    Productos Profesionales
                </h1>
                <p class="text-xl text-white/90 mb-6">
                    Descubre nuestra colección exclusiva con la calidad colombiana que nos caracteriza
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="#productos" class="bg-yellow-500 hover:bg-yellow-600 text-black font-bold px-6 py-3 rounded">
                        Ver Productos
                    </a>
                    <a href="https://wa.me/573188763377" target="_blank" class="bg-green-500 hover:bg-green-600 text-white font-bold px-6 py-3 rounded-lg transition-all duration-300 transform hover:scale-105">
                        <i class="fab fa-whatsapp mr-2"></i>
                        Consultar
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Contenedor de partículas -->


<div class="min-h-screen bg-white relative z-10">
    <!-- Hero Section -->
    <section class="relative py-20 overflow-hidden">


        
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center max-w-4xl mx-auto">
                <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6">
                    🎱 Tacos de Billar Profesionales
                </h1>
                <p class="text-xl text-gray-600 mb-8 fade-in-up" style="animation-delay: 0.2s;">
                    Descubre nuestra colección exclusiva de tacos de billar de alta calidad, diseñados para jugadores exigentes que buscan precisión y elegancia
                </p>
                
                <!-- Estadísticas animadas -->
                <div class="grid grid-cols-3 gap-6 max-w-2xl mx-auto mb-8 fade-in-up" style="animation-delay: 0.3s;">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600 counter" data-target="150">0</div>
                        <div class="text-sm text-gray-600">Modelos</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-purple-600 counter" data-target="98">0</div>
                        <div class="text-sm text-gray-600">% Satisfacción</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-600 counter" data-target="5000">0</div>
                        <div class="text-sm text-gray-600">Clientes</div>
                    </div>
                </div>
                
                <!-- Barra de búsqueda -->
                <div class="max-w-2xl mx-auto mb-8">
                    <div class="relative">
                        <input type="text" 
                               placeholder="Buscar tacos de billar..." 
                               class="w-full px-6 py-4 pl-14 text-lg border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none bg-white">
                        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-xl">
                            🔍
                        </div>
                        <button class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                            Buscar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

<div class="bg-white min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- Filtros y búsqueda -->
        <div class="bg-white rounded p-6 mb-8">
            <div class="flex flex-col lg:flex-row gap-4 items-center justify-between">
                <!-- Barra de búsqueda -->
                <div class="flex-1 max-w-md">
                    <div class="relative">
                        <input type="text" 
                               placeholder="Buscar productos..." 
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
                
                <!-- Filtros -->
                <div class="flex flex-wrap gap-3">
                    <button class="px-6 py-3 bg-blue-600 text-white rounded font-medium">
                        <i class="fas fa-th-large mr-2"></i>
                        Todos
                    </button>
                    <button class="px-6 py-3 bg-white border-2 border-gray-200 text-gray-700 rounded font-medium hover:border-blue-500 hover:text-blue-600">
                        <i class="fas fa-star mr-2"></i>
                        Destacados
                    </button>
                    <button class="px-6 py-3 bg-white border-2 border-gray-200 text-gray-700 rounded font-medium hover:border-blue-500 hover:text-blue-600">
                        <i class="fas fa-sort-amount-up mr-2"></i>
                        Precio ↑
                    </button>
                    <button class="px-6 py-3 bg-white border-2 border-gray-200 text-gray-700 rounded font-medium hover:border-blue-500 hover:text-blue-600">
                        <i class="fas fa-sort-amount-down mr-2"></i>
                        Precio ↓
                    </button>
                </div>
            </div>
        </div>

        <!-- Grid de productos -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            <?php foreach ($productos as $producto): ?>
                <div class="bg-white rounded overflow-hidden flex flex-col h-full">
                    <!-- Imagen del producto -->
                    <div class="relative overflow-hidden flex-shrink-0">
                        <?php if (!empty($producto['imagenes']) && isset($producto['imagenes'][0])): ?>
                            <img src="<?= htmlspecialchars($producto['imagenes'][0]['url']) ?>" 
                                 alt="<?= htmlspecialchars($producto['nombre']) ?>"
                                 class="w-full h-56 object-cover">
                        <?php elseif (!empty($producto['portada'])): ?>
                            <img src="<?= htmlspecialchars($producto['portada']) ?>" 
                                 alt="<?= htmlspecialchars($producto['nombre']) ?>"
                                 class="w-full h-56 object-cover">
                        <?php else: ?>
                            <div class="w-full h-56 bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-image text-blue-600 text-4xl"></i>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Badge de precio -->
                        <div class="absolute top-4 right-4">
                            <span class="bg-white text-blue-600 font-bold px-3 py-1.5 rounded-full text-sm border border-gray-200">
                                $<?= $producto['precio_formateado'] ?>
                            </span>
                        </div>
                        
                        <?php if ($producto['destacado']): ?>
                            <div class="absolute top-4 left-4 bg-red-600 text-white px-3 py-1.5 rounded-full text-xs font-semibold">
                                ⭐ Destacado
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Información del producto -->
                    <div class="p-6 flex flex-col flex-grow">
                        <!-- Título del producto -->
                        <h3 class="text-lg font-bold text-gray-900 mb-3 line-clamp-2 min-h-[3.5rem]">
                            <?= htmlspecialchars($producto['nombre']) ?>
                        </h3>
                        
                        <!-- Descripción estandarizada -->
                        <p class="text-gray-600 mb-4 text-sm leading-relaxed flex-grow min-h-[4rem]">
                            <?php 
                            $descripcion = htmlspecialchars($producto['descripcion']);
                            echo strlen($descripcion) > 100 ? substr($descripcion, 0, 100) . '...' : $descripcion;
                            ?>
                        </p>
                        
                        <!-- Rating y características -->
                        <div class="flex items-center justify-between mb-4 mt-auto">
                            <div class="flex items-center">
                                <div class="flex text-colombia-yellow">
                                    <i class="fas fa-star text-sm"></i>
                                    <i class="fas fa-star text-sm"></i>
                                    <i class="fas fa-star text-sm"></i>
                                    <i class="fas fa-star text-sm"></i>
                                    <i class="fas fa-star text-sm"></i>
                                </div>
                                <span class="text-xs text-gray-500 ml-2">(5.0)</span>
                            </div>
                            <span class="text-xs bg-colombia-blue/10 text-colombia-blue px-2 py-1 rounded-full font-medium border border-colombia-blue/20">
                                🇨🇴 Profesional
                            </span>
                        </div>
                        
                        <!-- Botón principal -->
                        <a href="/productos/<?= $producto['slug'] ?>" 
                           class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-3 px-4 rounded font-medium">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            Ver producto
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Paginación -->
        <?php if (isset($pagination) && $pagination['total_pages'] > 1): ?>
            <div class="mt-16">
                <nav class="flex justify-center">
                    <div class="bg-white rounded p-4 flex items-center space-x-2">
                        <?php if ($pagination['current_page'] > 1): ?>
                            <a href="?page=<?= $pagination['current_page'] - 1 ?>" 
                               class="px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 flex items-center">
                                <i class="fas fa-chevron-left mr-2"></i>
                                Anterior
                            </a>
                        <?php endif; ?>
                        
                        <?php 
                        $start = max(1, $pagination['current_page'] - 2);
                        $end = min($pagination['total_pages'], $pagination['current_page'] + 2);
                        ?>
                        
                        <?php if ($start > 1): ?>
                            <a href="?page=1" class="px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200">1</a>
                            <?php if ($start > 2): ?>
                                <span class="px-2 text-gray-400">...</span>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                        <?php for ($i = $start; $i <= $end; $i++): ?>
                            <a href="?page=<?= $i ?>" 
                               class="px-4 py-2 <?= $i === $pagination['current_page'] ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' ?> rounded font-medium">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>
                        
                        <?php if ($end < $pagination['total_pages']): ?>
                            <?php if ($end < $pagination['total_pages'] - 1): ?>
                                <span class="px-2 text-gray-400">...</span>
                            <?php endif; ?>
                            <a href="?page=<?= $pagination['total_pages'] ?>" class="px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200"><?= $pagination['total_pages'] ?></a>
                        <?php endif; ?>
                        
                        <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                            <a href="?page=<?= $pagination['current_page'] + 1 ?>" 
                               class="px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 flex items-center">
                                Siguiente
                                <i class="fas fa-chevron-right ml-2"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </nav>
            </div>
        <?php endif; ?>

        <!-- Sección de llamada a la acción -->
        <div class="mt-20">
            <div class="bg-blue-600 rounded p-8 lg:p-12 text-center text-white">
                <div class="mb-6">
                    <i class="fas fa-tools text-4xl text-blue-200 mb-4"></i>
                </div>
                <h2 class="text-3xl lg:text-4xl font-bold mb-6">¿No encuentras lo que buscas?</h2>
                <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto leading-relaxed">
                    Ofrecemos servicios de personalización y fabricación de tacos únicos. 
                    Contáctanos para crear el taco perfecto para ti.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="https://wa.me/573188763377?text=Hola, me gustaría información sobre tacos personalizados" 
                       target="_blank"
                       class="inline-flex items-center justify-center px-8 py-4 bg-white text-blue-600 font-bold rounded">
                        <i class="fab fa-whatsapp mr-3 text-green-500"></i>
                        Consultar personalización
                    </a>
                    
                    <a href="/contacto" 
                       class="inline-flex items-center justify-center px-8 py-4 border-2 border-white text-white font-bold rounded hover:bg-white hover:text-blue-600">
                        <i class="fas fa-envelope mr-3"></i>
                        Más información
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>