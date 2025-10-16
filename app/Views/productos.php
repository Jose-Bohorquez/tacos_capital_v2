<?php $this->layout('layout', ['title' => 'Productos - Tacos Capital', 'description' => 'Descubre nuestra amplia selección de tacos de billar profesionales']) ?>

<!-- Elementos decorativos de fondo -->
<div class="fixed inset-0 overflow-hidden pointer-events-none">
    <div class="absolute -top-40 -right-40 w-96 h-96 bg-gradient-to-br from-blue-400/10 to-purple-600/10 rounded-full blur-3xl parallax" data-speed="0.2"></div>
    <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-tr from-green-400/10 to-blue-600/10 rounded-full blur-3xl parallax" data-speed="0.3"></div>
    <div class="absolute top-1/3 left-1/2 w-64 h-64 bg-gradient-to-r from-yellow-400/5 to-orange-600/5 rounded-full blur-2xl parallax" data-speed="0.1"></div>
    <div class="absolute top-2/3 right-1/4 w-48 h-48 bg-gradient-to-br from-pink-400/5 to-purple-600/5 rounded-full blur-xl parallax" data-speed="0.25"></div>
</div>

<!-- Contenedor de partículas -->
<div class="particles-container fixed inset-0 pointer-events-none"></div>

<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-blue-50 relative z-10">
    <!-- Hero Section -->
    <section class="relative py-20 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-600/10 to-purple-600/10"></div>
        <div class="absolute top-0 left-0 w-72 h-72 bg-blue-400/20 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
        <div class="absolute top-0 right-0 w-72 h-72 bg-purple-400/20 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-400/20 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
        
        <!-- Elementos decorativos adicionales -->
        <div class="absolute top-10 left-10 w-4 h-4 bg-yellow-400 rounded-full animate-ping"></div>
        <div class="absolute top-20 right-20 w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
        <div class="absolute bottom-20 left-1/4 w-2 h-2 bg-blue-400 rounded-full animate-bounce"></div>
        <div class="absolute bottom-10 right-1/3 w-5 h-5 bg-purple-400 rounded-full animate-spin"></div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center max-w-4xl mx-auto">
                <h1 class="text-5xl md:text-6xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-6 fade-in-up typewriter">
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
                
                <!-- Barra de búsqueda mejorada -->
                <div class="max-w-2xl mx-auto mb-8 fade-in-up" style="animation-delay: 0.4s;">
                    <div class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl blur opacity-25 group-hover:opacity-75 transition duration-1000"></div>
                        <div class="relative">
                            <input type="text" 
                                   placeholder="Buscar tacos de billar..." 
                                   class="w-full px-6 py-4 pl-14 text-lg border-2 border-gray-200 rounded-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all duration-300 bg-white/90 backdrop-blur-sm shadow-lg">
                            <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-xl">
                                🔍
                            </div>
                            <button class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-2 rounded-xl hover:scale-105 transition-all duration-300 shadow-lg btn-interactive">
                                Buscar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- Filtros y búsqueda -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <div class="flex flex-col lg:flex-row gap-4 items-center justify-between">
                <!-- Barra de búsqueda -->
                <div class="flex-1 max-w-md">
                    <div class="relative">
                        <input type="text" 
                               placeholder="Buscar productos..." 
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
                
                <!-- Filtros -->
                <div class="flex flex-wrap gap-3">
                    <button class="px-6 py-3 gradient-bg text-white rounded-xl font-medium shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                        <i class="fas fa-th-large mr-2"></i>
                        Todos
                    </button>
                    <button class="px-6 py-3 bg-white border-2 border-gray-200 text-gray-700 rounded-xl font-medium hover:border-primary-500 hover:text-primary-600 transition-all duration-200">
                        <i class="fas fa-star mr-2"></i>
                        Destacados
                    </button>
                    <button class="px-6 py-3 bg-white border-2 border-gray-200 text-gray-700 rounded-xl font-medium hover:border-primary-500 hover:text-primary-600 transition-all duration-200">
                        <i class="fas fa-sort-amount-up mr-2"></i>
                        Precio ↑
                    </button>
                    <button class="px-6 py-3 bg-white border-2 border-gray-200 text-gray-700 rounded-xl font-medium hover:border-primary-500 hover:text-primary-600 transition-all duration-200">
                        <i class="fas fa-sort-amount-down mr-2"></i>
                        Precio ↓
                    </button>
                </div>
            </div>
        </div>

        <!-- Grid de productos -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            <?php foreach ($productos as $producto): ?>
                <div class="group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                    <!-- Imagen del producto -->
                    <div class="relative overflow-hidden">
                        <?php if (!empty($producto['imagenes']) && isset($producto['imagenes'][0])): ?>
                            <img src="<?= htmlspecialchars($producto['imagenes'][0]['url']) ?>" 
                                 alt="<?= htmlspecialchars($producto['nombre']) ?>"
                                 class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                        <?php elseif (!empty($producto['portada'])): ?>
                            <img src="<?= htmlspecialchars($producto['portada']) ?>" 
                                 alt="<?= htmlspecialchars($producto['nombre']) ?>"
                                 class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                        <?php else: ?>
                            <div class="w-full h-64 bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                <i class="fas fa-image text-gray-500 text-4xl"></i>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Badge de precio -->
                        <div class="absolute top-4 right-4">
                            <span class="bg-white/90 backdrop-blur-sm text-primary-600 font-bold px-3 py-1 rounded-full text-sm shadow-lg">
                                $<?= $producto['precio_formateado'] ?>
                            </span>
                        </div>
                        
                        <?php if ($producto['destacado']): ?>
                            <div class="absolute top-4 left-4 bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-lg">
                                Destacado
                            </div>
                        <?php endif; ?>
                        
                        <!-- Overlay con botones de acción rápida -->
                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <div class="flex gap-3">
                                <a href="/productos/<?= $producto['slug'] ?>" 
                                   class="bg-white text-gray-900 p-3 rounded-full hover:bg-gray-100 transition-colors duration-200 shadow-lg">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="https://wa.me/573188763377?text=Hola, me interesa el producto: <?= urlencode($producto['nombre']) ?>" 
                                   target="_blank"
                                   class="bg-green-500 text-white p-3 rounded-full hover:bg-green-600 transition-colors duration-200 shadow-lg">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Información del producto -->
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-primary-600 transition-colors duration-200">
                            <?= htmlspecialchars($producto['nombre']) ?>
                        </h3>
                        
                        <p class="text-gray-600 mb-4 line-clamp-3 leading-relaxed">
                            <?= htmlspecialchars(substr($producto['descripcion'], 0, 120)) ?>...
                        </p>
                        
                        <!-- Rating y características -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="flex text-yellow-400">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="text-sm text-gray-500 ml-2">(5.0)</span>
                            </div>
                            <span class="text-xs bg-primary-100 text-primary-600 px-2 py-1 rounded-full font-medium">
                                Profesional
                            </span>
                        </div>
                        
                        <!-- Botón principal -->
                        <a href="/productos/<?= $producto['slug'] ?>" 
                           class="block w-full gradient-bg text-white text-center py-3 px-4 rounded-xl font-medium shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
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
                    <div class="bg-white rounded-2xl shadow-lg p-4 flex items-center space-x-2">
                        <?php if ($pagination['current_page'] > 1): ?>
                            <a href="?page=<?= $pagination['current_page'] - 1 ?>" 
                               class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 flex items-center">
                                <i class="fas fa-chevron-left mr-2"></i>
                                Anterior
                            </a>
                        <?php endif; ?>
                        
                        <?php 
                        $start = max(1, $pagination['current_page'] - 2);
                        $end = min($pagination['total_pages'], $pagination['current_page'] + 2);
                        ?>
                        
                        <?php if ($start > 1): ?>
                            <a href="?page=1" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200">1</a>
                            <?php if ($start > 2): ?>
                                <span class="px-2 text-gray-400">...</span>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                        <?php for ($i = $start; $i <= $end; $i++): ?>
                            <a href="?page=<?= $i ?>" 
                               class="px-4 py-2 <?= $i === $pagination['current_page'] ? 'gradient-bg text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' ?> rounded-xl transition-all duration-200 font-medium">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>
                        
                        <?php if ($end < $pagination['total_pages']): ?>
                            <?php if ($end < $pagination['total_pages'] - 1): ?>
                                <span class="px-2 text-gray-400">...</span>
                            <?php endif; ?>
                            <a href="?page=<?= $pagination['total_pages'] ?>" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200"><?= $pagination['total_pages'] ?></a>
                        <?php endif; ?>
                        
                        <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                            <a href="?page=<?= $pagination['current_page'] + 1 ?>" 
                               class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 flex items-center">
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
            <div class="gradient-bg rounded-3xl shadow-2xl p-8 lg:p-12 text-center text-white relative overflow-hidden">
                <!-- Elementos decorativos -->
                <div class="absolute top-0 left-0 w-32 h-32 bg-white/10 rounded-full -translate-x-16 -translate-y-16"></div>
                <div class="absolute bottom-0 right-0 w-40 h-40 bg-white/10 rounded-full translate-x-20 translate-y-20"></div>
                
                <div class="relative z-10">
                    <div class="mb-6">
                        <i class="fas fa-tools text-4xl text-orange-200 mb-4"></i>
                    </div>
                    <h2 class="text-3xl lg:text-4xl font-bold mb-6">¿No encuentras lo que buscas?</h2>
                    <p class="text-xl text-orange-100 mb-8 max-w-2xl mx-auto leading-relaxed">
                        Ofrecemos servicios de personalización y fabricación de tacos únicos. 
                        Contáctanos para crear el taco perfecto para ti.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="https://wa.me/573188763377?text=Hola, me gustaría información sobre tacos personalizados" 
                           target="_blank"
                           class="inline-flex items-center justify-center px-8 py-4 bg-white text-primary-600 font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200">
                            <i class="fab fa-whatsapp mr-3 text-green-500"></i>
                            Consultar personalización
                        </a>
                        
                        <a href="/contacto" 
                           class="inline-flex items-center justify-center px-8 py-4 border-2 border-white text-white font-bold rounded-xl hover:bg-white hover:text-primary-600 transition-all duration-200">
                            <i class="fas fa-envelope mr-3"></i>
                            Más información
                        </a>
                    </div>
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