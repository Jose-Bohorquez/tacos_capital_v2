<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<!-- Hero Section con Banner Mejorado -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden">
  <!-- Banner de fondo con efectos -->
  <div class="absolute inset-0 z-0">
    <img src="/assets/img/banner_tacos_capital.svg" alt="Tacos Capital Banner" class="w-full h-full object-cover">
    <div class="absolute inset-0 bg-gradient-to-br from-black/60 via-black/40 to-transparent"></div>
    <!-- Efectos de partículas flotantes -->
    <div class="absolute inset-0 overflow-hidden">
      <div class="absolute top-1/4 left-1/4 w-2 h-2 bg-yellow-400 rounded-full animate-ping opacity-75"></div>
      <div class="absolute top-3/4 right-1/4 w-1 h-1 bg-blue-400 rounded-full animate-pulse opacity-60"></div>
      <div class="absolute top-1/2 left-3/4 w-3 h-3 bg-white rounded-full animate-bounce opacity-40"></div>
    </div>
  </div>
  
  <!-- Contenido del Hero -->
  <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
    <div class="max-w-5xl mx-auto">
      <!-- Badge superior -->
      <div class="inline-flex items-center bg-yellow-500/20 backdrop-blur-sm border border-yellow-400/30 rounded-full px-6 py-2 mb-8">
        <span class="text-yellow-400 font-semibold text-sm sm:text-base">🏆 #1 en Tacos Profesionales</span>
      </div>
      
      <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-8xl font-black text-white mb-6 leading-tight">
        <span class="bg-gradient-to-r from-white via-blue-200 to-yellow-400 bg-clip-text text-transparent">
          Tacos de Billar
        </span>
        <span class="block text-yellow-400 drop-shadow-2xl animate-pulse">
          Profesionales
        </span>
      </h1>
      
      <p class="text-lg sm:text-xl md:text-2xl text-gray-200 mb-10 max-w-4xl mx-auto leading-relaxed font-light">
        🎱 Fabricación artesanal con los mejores materiales. Calidad profesional para jugadores exigentes que buscan la <span class="text-yellow-400 font-semibold">perfección</span> en cada jugada.
      </p>
      
      <!-- Estadísticas rápidas -->
      <div class="grid grid-cols-3 gap-4 sm:gap-8 mb-10 max-w-2xl mx-auto">
        <div class="text-center">
          <div class="text-2xl sm:text-3xl font-bold text-yellow-400">500+</div>
          <div class="text-xs sm:text-sm text-gray-300">Tacos Vendidos</div>
        </div>
        <div class="text-center">
          <div class="text-2xl sm:text-3xl font-bold text-blue-400">15+</div>
          <div class="text-xs sm:text-sm text-gray-300">Años Experiencia</div>
        </div>
        <div class="text-center">
          <div class="text-2xl sm:text-3xl font-bold text-green-400">100%</div>
          <div class="text-xs sm:text-sm text-gray-300">Satisfacción</div>
        </div>
      </div>
      
      <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
        <a href="/productos" class="group w-full sm:w-auto bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 transform hover:scale-105 shadow-2xl hover:shadow-blue-500/25">
          <span class="flex items-center justify-center">
            🎯 Ver Productos
            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
          </span>
        </a>
        <a href="#servicios" class="group w-full sm:w-auto border-2 border-white/80 backdrop-blur-sm text-white hover:bg-white hover:text-gray-900 px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 transform hover:scale-105">
          <span class="flex items-center justify-center">
            🔧 Nuestros Servicios
            <i class="fas fa-chevron-down ml-2 group-hover:translate-y-1 transition-transform"></i>
          </span>
        </a>
      </div>
      
      <!-- Scroll indicator -->
      <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <div class="w-6 h-10 border-2 border-white/50 rounded-full flex justify-center">
          <div class="w-1 h-3 bg-white/70 rounded-full mt-2 animate-pulse"></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Features Section Mejorada -->
<section class="py-16 lg:py-24 bg-gradient-to-br from-gray-50 via-white to-blue-50 relative overflow-hidden">
  <!-- Elementos decorativos de fondo -->
  <div class="absolute top-0 left-0 w-72 h-72 bg-blue-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
  <div class="absolute top-0 right-0 w-72 h-72 bg-yellow-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
  <div class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>
  
  <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16">
      <div class="inline-flex items-center bg-blue-100 rounded-full px-6 py-2 mb-6">
        <span class="text-blue-600 font-semibold text-sm">✨ NUESTRAS VENTAJAS</span>
      </div>
      <h2 class="text-3xl sm:text-4xl lg:text-6xl font-black text-gray-900 mb-6">
        ¿Por qué elegir 
        <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
          Tacos Capital?
        </span>
      </h2>
      <p class="text-lg sm:text-xl text-gray-600 max-w-4xl mx-auto leading-relaxed">
        Nos especializamos en crear tacos de billar de la más alta calidad con atención al detalle que marca la diferencia
      </p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
      <!-- Feature 1 -->
      <div class="group relative">
        <div class="bg-white rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
          <div class="absolute -top-6 left-8">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
              <i class="fas fa-hammer text-xl text-white"></i>
            </div>
          </div>
          <div class="pt-8">
            <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4 group-hover:text-blue-600 transition-colors">
              🔨 Fabricación Artesanal
            </h3>
            <p class="text-gray-600 leading-relaxed mb-4">
              Cada taco es elaborado a mano por artesanos expertos con décadas de experiencia en el oficio.
            </p>
            <div class="flex items-center text-blue-600 font-semibold text-sm">
              <span>Más de 15 años de experiencia</span>
              <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Feature 2 -->
      <div class="group relative">
        <div class="bg-white rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
          <div class="absolute -top-6 left-8">
            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
              <i class="fas fa-gem text-xl text-white"></i>
            </div>
          </div>
          <div class="pt-8">
            <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4 group-hover:text-purple-600 transition-colors">
              💎 Materiales Premium
            </h3>
            <p class="text-gray-600 leading-relaxed mb-4">
              Utilizamos únicamente maderas selectas y materiales de la más alta calidad para garantizar durabilidad.
            </p>
            <div class="flex items-center text-purple-600 font-semibold text-sm">
              <span>Maderas importadas certificadas</span>
              <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Feature 3 -->
      <div class="group relative">
        <div class="bg-white rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
          <div class="absolute -top-6 left-8">
            <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
              <i class="fas fa-trophy text-xl text-white"></i>
            </div>
          </div>
          <div class="pt-8">
            <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4 group-hover:text-yellow-600 transition-colors">
              🏆 Calidad Profesional
            </h3>
            <p class="text-gray-600 leading-relaxed mb-4">
              Tacos utilizados por jugadores profesionales y reconocidos en competencias nacionales e internacionales.
            </p>
            <div class="flex items-center text-yellow-600 font-semibold text-sm">
              <span>Usados por campeones</span>
              <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Testimonial rápido -->
    <div class="mt-16 text-center">
      <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-8 max-w-4xl mx-auto border border-gray-200 shadow-xl">
        <div class="flex items-center justify-center mb-4">
          <div class="flex text-yellow-400 text-2xl">
            ⭐⭐⭐⭐⭐
          </div>
        </div>
        <blockquote class="text-lg sm:text-xl text-gray-700 italic mb-4">
          "Los mejores tacos que he usado en mi carrera. La calidad y precisión son incomparables."
        </blockquote>
        <cite class="text-blue-600 font-semibold">- Carlos Mendoza, Campeón Nacional 2023</cite>
      </div>
    </div>
  </div>
</section>

<!-- Services Section Mejorada -->
<section id="servicios" class="py-16 lg:py-24 bg-gradient-to-br from-blue-900 via-blue-800 to-purple-900 relative overflow-hidden">
  <!-- Efectos de fondo -->
  <div class="absolute inset-0">
    <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-pulse"></div>
    <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-pulse animation-delay-2000"></div>
  </div>
  
  <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16">
      <div class="inline-flex items-center bg-white/10 backdrop-blur-sm rounded-full px-6 py-2 mb-6">
        <span class="text-blue-200 font-semibold text-sm">🔧 SERVICIOS ESPECIALIZADOS</span>
      </div>
      <h2 class="text-3xl sm:text-4xl lg:text-6xl font-black text-white mb-6">
        Nuestros 
        <span class="bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent">
          Servicios
        </span>
      </h2>
      <p class="text-lg sm:text-xl text-blue-200 max-w-4xl mx-auto leading-relaxed">
        Ofrecemos servicios especializados para mantener y personalizar tu taco de billar con la más alta calidad
      </p>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
      <!-- Servicio 1 -->
      <div class="group relative">
        <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/20 hover:bg-white/15 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl">
          <div class="flex flex-col sm:flex-row items-start gap-6">
            <div class="relative w-full sm:w-32 h-32 rounded-xl overflow-hidden flex-shrink-0">
              <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                <i class="fas fa-tools text-4xl text-white"></i>
              </div>
              <div class="absolute inset-0 bg-black/20"></div>
            </div>
            <div class="flex-1">
              <div class="flex items-center mb-4">
                <div class="w-3 h-3 bg-yellow-400 rounded-full mr-3 animate-pulse"></div>
                <h3 class="text-xl sm:text-2xl font-bold text-white group-hover:text-yellow-400 transition-colors">
                  🔧 Cambio de Virolas
                </h3>
              </div>
              <p class="text-blue-200 mb-6 leading-relaxed">
                Reemplazamos virolas desgastadas con materiales de alta calidad. Servicio profesional que garantiza el mejor rendimiento de tu taco.
              </p>
              <div class="flex flex-col sm:flex-row gap-3">
                <a href="https://wa.me/573188763377?text=Hola, necesito información sobre el cambio de virolas" target="_blank" class="group/btn inline-flex items-center bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-3 rounded-xl font-semibold transition-all transform hover:scale-105">
                  <i class="fab fa-whatsapp mr-2 text-lg"></i>
                  Consultar Precio
                  <i class="fas fa-arrow-right ml-2 group-hover/btn:translate-x-1 transition-transform"></i>
                </a>
                <div class="text-yellow-400 font-semibold text-sm flex items-center">
                  <i class="fas fa-clock mr-2"></i>
                  Servicio en 24h
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Servicio 2 -->
      <div class="group relative">
        <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/20 hover:bg-white/15 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl">
          <div class="flex flex-col sm:flex-row items-start gap-6">
            <div class="relative w-full sm:w-32 h-32 rounded-xl overflow-hidden flex-shrink-0">
              <div class="absolute inset-0 bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center">
                <i class="fas fa-paint-brush text-4xl text-white"></i>
              </div>
              <div class="absolute inset-0 bg-black/20"></div>
            </div>
            <div class="flex-1">
              <div class="flex items-center mb-4">
                <div class="w-3 h-3 bg-yellow-400 rounded-full mr-3 animate-pulse"></div>
                <h3 class="text-xl sm:text-2xl font-bold text-white group-hover:text-yellow-400 transition-colors">
                  🎨 Personalización
                </h3>
              </div>
              <p class="text-blue-200 mb-6 leading-relaxed">
                Diseños únicos y grabados personalizados. Haz que tu taco sea verdaderamente tuyo con nuestros servicios de personalización.
              </p>
              <div class="flex flex-col sm:flex-row gap-3">
                <a href="https://wa.me/573188763377?text=Hola, quiero personalizar mi taco de billar" target="_blank" class="group/btn inline-flex items-center bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-3 rounded-xl font-semibold transition-all transform hover:scale-105">
                  <i class="fab fa-whatsapp mr-2 text-lg"></i>
                  Consultar Precio
                  <i class="fas fa-arrow-right ml-2 group-hover/btn:translate-x-1 transition-transform"></i>
                </a>
                <div class="text-yellow-400 font-semibold text-sm flex items-center">
                  <i class="fas fa-star mr-2"></i>
                  Diseños únicos
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Información adicional de servicios -->
    <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="text-center">
        <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-4">
          <i class="fas fa-shipping-fast text-2xl text-yellow-400"></i>
        </div>
        <h4 class="text-white font-semibold mb-2">Envío Gratis</h4>
        <p class="text-blue-200 text-sm">En servicios superiores a $100.000</p>
      </div>
      <div class="text-center">
        <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-4">
          <i class="fas fa-shield-alt text-2xl text-yellow-400"></i>
        </div>
        <h4 class="text-white font-semibold mb-2">Garantía Total</h4>
        <p class="text-blue-200 text-sm">6 meses en todos nuestros servicios</p>
      </div>
      <div class="text-center">
        <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-4">
          <i class="fas fa-headset text-2xl text-yellow-400"></i>
        </div>
        <h4 class="text-white font-semibold mb-2">Soporte 24/7</h4>
        <p class="text-blue-200 text-sm">Atención personalizada siempre</p>
      </div>
    </div>
  </div>
</section>

<!-- Featured Products Section Mejorada -->
<section class="py-16 lg:py-24 bg-gradient-to-br from-gray-50 to-gray-100 relative overflow-hidden">
  <!-- Efectos de fondo -->
  <div class="absolute inset-0">
    <div class="absolute top-1/3 left-1/3 w-96 h-96 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
    <div class="absolute bottom-1/3 right-1/3 w-96 h-96 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse animation-delay-2000"></div>
  </div>
  
  <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16">
      <div class="inline-flex items-center bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-full px-6 py-2 mb-6">
        <span class="font-semibold text-sm">⭐ PRODUCTOS DESTACADOS</span>
      </div>
      <h2 class="text-3xl sm:text-4xl lg:text-6xl font-black text-gray-900 mb-6">
        Nuestros 
        <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
          Bestsellers
        </span>
      </h2>
      <p class="text-lg sm:text-xl text-gray-600 max-w-4xl mx-auto leading-relaxed">
        Descubre nuestra selección de tacos más populares y mejor valorados por jugadores profesionales
      </p>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 lg:gap-8">
      <?php if (!empty($productos)): ?>
        <?php foreach (array_slice($productos, 0, 8) as $index => $producto): ?>
          <div class="group relative">
            <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-200">
              <div class="relative overflow-hidden">
                <img src="<?= $producto['imagen'] ?>" alt="<?= $producto['nombre'] ?>" class="w-full h-48 sm:h-56 object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="absolute top-3 left-3">
                  <span class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-3 py-1 rounded-full text-sm font-bold shadow-lg">
                    🏆 #<?= $index + 1 ?>
                  </span>
                </div>
                <div class="absolute top-3 right-3">
                  <div class="bg-white/90 backdrop-blur-sm rounded-full p-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <i class="fas fa-heart text-red-500 text-sm"></i>
                  </div>
                </div>
              </div>
              <div class="p-6">
                <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-blue-600 transition-colors">
                  <?= $producto['nombre'] ?>
                </h3>
                <div class="flex items-center justify-between mb-3">
                  <p class="text-2xl sm:text-3xl font-black text-blue-600">
                    $<?= number_format($producto['precio'], 0, ',', '.') ?>
                  </p>
                  <div class="flex items-center text-yellow-400">
                    <i class="fas fa-star text-sm"></i>
                    <i class="fas fa-star text-sm"></i>
                    <i class="fas fa-star text-sm"></i>
                    <i class="fas fa-star text-sm"></i>
                    <i class="fas fa-star text-sm"></i>
                    <span class="text-gray-500 text-sm ml-1">(4.9)</span>
                  </div>
                </div>
                <p class="text-gray-600 text-sm mb-6 line-clamp-3 leading-relaxed">
                  <?= $producto['descripcion_corta'] ?>
                </p>
                <div class="space-y-3">
                  <a href="/producto/<?= $producto['id'] ?>" class="group/btn block w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-center py-3 rounded-xl font-semibold transition-all transform hover:scale-105 shadow-lg">
                    Ver detalles
                    <i class="fas fa-arrow-right ml-2 group-hover/btn:translate-x-1 transition-transform"></i>
                  </a>
                  <button class="w-full bg-green-50 hover:bg-green-100 text-green-700 py-2 rounded-xl font-medium transition-colors border border-green-200">
                    <i class="fab fa-whatsapp mr-2"></i>
                    Consultar
                  </button>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="col-span-full text-center py-12">
          <div class="bg-white rounded-2xl p-8 shadow-lg">
            <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 text-lg">No hay productos disponibles en este momento.</p>
          </div>
        </div>
      <?php endif; ?>
    </div>
    
    <div class="text-center mt-16">
      <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-8 shadow-lg inline-block">
        <h3 class="text-2xl font-bold text-gray-900 mb-4">¿Quieres ver más opciones?</h3>
        <p class="text-gray-600 mb-6">Explora nuestro catálogo completo con más de 50 modelos diferentes</p>
        <a href="/productos" class="group inline-flex items-center bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all transform hover:scale-105 shadow-lg">
          <i class="fas fa-th-large mr-3 text-xl"></i>
          Ver Catálogo Completo
          <i class="fas fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform"></i>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- Call to Action Section Mejorada -->
<section class="py-16 lg:py-24 bg-gradient-to-br from-gray-900 via-blue-900 to-purple-900 relative overflow-hidden">
  <!-- Efectos de fondo -->
  <div class="absolute inset-0">
    <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
    <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse animation-delay-2000"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-yellow-400 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-pulse animation-delay-4000"></div>
  </div>
  
  <!-- Patrón de puntos -->
  <div class="absolute inset-0 opacity-10">
    <div class="absolute inset-0" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 20px 20px;"></div>
  </div>
  
  <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
    <div class="max-w-5xl mx-auto">
      <!-- Badge superior -->
      <div class="inline-flex items-center bg-gradient-to-r from-yellow-400 to-orange-500 text-gray-900 rounded-full px-6 py-2 mb-8 font-bold text-sm">
        <span>🚀 ÚNETE A MÁS DE 1,000 JUGADORES SATISFECHOS</span>
      </div>
      
      <h2 class="text-4xl sm:text-5xl lg:text-7xl font-black text-white mb-8 leading-tight">
        ¿Listo para 
        <span class="bg-gradient-to-r from-yellow-400 to-orange-500 bg-clip-text text-transparent">
          Dominar
        </span>
        <br class="hidden sm:block">
        la Mesa?
      </h2>
      
      <p class="text-lg sm:text-xl text-blue-200 mb-12 max-w-4xl mx-auto leading-relaxed">
        Contáctanos hoy mismo y descubre cómo nuestros tacos pueden llevar tu juego al siguiente nivel. 
        <span class="text-yellow-400 font-semibold">Asesoría personalizada</span> y productos de 
        <span class="text-yellow-400 font-semibold">calidad profesional</span> te esperan.
      </p>
      
      <!-- Estadísticas rápidas -->
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-12">
        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
          <div class="text-3xl sm:text-4xl font-black text-yellow-400 mb-2">1000+</div>
          <div class="text-blue-200 font-medium">Clientes Satisfechos</div>
        </div>
        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
          <div class="text-3xl sm:text-4xl font-black text-yellow-400 mb-2">15+</div>
          <div class="text-blue-200 font-medium">Años de Experiencia</div>
        </div>
        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
          <div class="text-3xl sm:text-4xl font-black text-yellow-400 mb-2">99%</div>
          <div class="text-blue-200 font-medium">Satisfacción Garantizada</div>
        </div>
      </div>
      
      <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
        <a href="https://wa.me/573188763377?text=Hola, quiero información sobre sus tacos de billar" target="_blank" class="group w-full sm:w-auto bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-10 py-5 rounded-2xl font-bold text-lg transition-all transform hover:scale-105 shadow-2xl inline-flex items-center justify-center">
          <i class="fab fa-whatsapp mr-3 text-2xl"></i>
          Contactar por WhatsApp
          <i class="fas fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform"></i>
        </a>
        <a href="/productos" class="group w-full sm:w-auto bg-white/10 backdrop-blur-sm border-2 border-white/30 text-white hover:bg-white hover:text-gray-900 px-10 py-5 rounded-2xl font-bold text-lg transition-all transform hover:scale-105 shadow-lg">
          <i class="fas fa-th-large mr-3"></i>
          Ver Catálogo Completo
          <i class="fas fa-external-link-alt ml-3 group-hover:translate-x-1 transition-transform"></i>
        </a>
      </div>
      
      <!-- Garantías -->
      <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="flex items-center justify-center text-blue-200">
          <i class="fas fa-shipping-fast text-2xl mr-3 text-yellow-400"></i>
          <span class="font-medium">Envío Gratis Nacional</span>
        </div>
        <div class="flex items-center justify-center text-blue-200">
          <i class="fas fa-shield-alt text-2xl mr-3 text-yellow-400"></i>
          <span class="font-medium">Garantía de 6 Meses</span>
        </div>
        <div class="flex items-center justify-center text-blue-200">
          <i class="fas fa-undo text-2xl mr-3 text-yellow-400"></i>
          <span class="font-medium">Devolución 30 Días</span>
        </div>
      </div>
    </div>
  </div>
</section>

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
  
  /* Animaciones personalizadas */
  @keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
  }
  
  @keyframes pulse-glow {
    0%, 100% { box-shadow: 0 0 20px rgba(59, 130, 246, 0.3); }
    50% { box-shadow: 0 0 40px rgba(59, 130, 246, 0.6); }
  }
  
  @keyframes gradient-shift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
  }
  
  .animation-delay-2000 {
    animation-delay: 2s;
  }
  
  .animation-delay-4000 {
    animation-delay: 4s;
  }
  
  .float-animation {
    animation: float 3s ease-in-out infinite;
  }
  
  .pulse-glow {
    animation: pulse-glow 2s ease-in-out infinite;
  }
  
  .gradient-shift {
    background-size: 200% 200%;
    animation: gradient-shift 3s ease infinite;
  }
  
  /* Efectos de hover mejorados */
  .hover-lift {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }
  
  .hover-lift:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
  }
  
  /* Efectos de texto brillante */
  .text-glow {
    text-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
  }
  
  /* Botones con efectos especiales */
  .btn-special {
    position: relative;
    overflow: hidden;
  }
  
  .btn-special::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
  }
  
  .btn-special:hover::before {
    left: 100%;
  }
</style>

<?= $this->endSection() ?>