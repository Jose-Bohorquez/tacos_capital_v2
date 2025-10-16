<?php $this->layout('layout', ['title' => $producto['nombre'], 'description' => $producto['descripcion'] ?? 'Delicioso producto de Tacos Capital']) ?>

<!-- Elementos decorativos de fondo -->
<div class="fixed inset-0 overflow-hidden pointer-events-none">
    <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-blue-400/10 to-purple-600/10 rounded-full blur-3xl parallax" data-speed="0.2"></div>
    <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-gradient-to-tr from-green-400/10 to-blue-600/10 rounded-full blur-3xl parallax" data-speed="0.3"></div>
    <div class="absolute top-1/2 left-1/4 w-32 h-32 bg-gradient-to-r from-yellow-400/5 to-orange-600/5 rounded-full blur-2xl parallax" data-speed="0.1"></div>
</div>

<!-- Contenedor de partículas -->
<div class="particles-container fixed inset-0 pointer-events-none"></div>

<!-- Breadcrumb -->
<nav class="bg-white/80 backdrop-blur-sm border-b border-gray-200 py-4 relative z-10" aria-label="breadcrumb">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <ol class="flex items-center space-x-2 text-sm bg-white/80 backdrop-blur-sm rounded-full px-4 py-2 shadow-lg">
      <li>
        <a href="/" class="text-gray-500 hover:text-primary-600 transition-all duration-300 hover:scale-105">
          🏠 <i class="fas fa-home"></i>
        </a>
      </li>
      <li class="text-gray-400">/</li>
      <li>
        <a href="/productos" class="text-gray-500 hover:text-primary-600 transition-all duration-300 hover:scale-105">🎱 Productos</a>
      </li>
      <li class="text-gray-400">/</li>
      <li class="text-gray-900 font-medium truncate"><?= htmlspecialchars($producto['nombre']) ?></li>
    </ol>
  </div>
</nav>

<div class="bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
      
      <!-- Galería de imágenes -->
      <div class="space-y-4 fade-in-left">
        <?php if (!empty($producto['imagenes'])): ?>
          <!-- Imagen principal con efectos mejorados -->
          <div class="relative group">
            <!-- Elementos decorativos alrededor de la imagen -->
            <div class="absolute -inset-4 bg-gradient-to-r from-blue-600/20 to-purple-600/20 rounded-3xl blur-xl opacity-0 group-hover:opacity-100 transition-all duration-500"></div>
            <div class="absolute -top-2 -right-2 w-8 h-8 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full animate-pulse"></div>
            <div class="absolute -bottom-2 -left-2 w-6 h-6 bg-gradient-to-br from-green-400 to-blue-500 rounded-full animate-bounce"></div>
            
            <div class="aspect-square bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl overflow-hidden shadow-2xl relative">
              <img src="<?= htmlspecialchars($producto['imagenes'][0]['url']) ?>" 
                   alt="<?= htmlspecialchars($producto['nombre']) ?>" 
                   id="mainImage"
                   class="w-full h-full object-cover group-hover:scale-110 transition-all duration-700 hover-glow">
              
              <!-- Badge de Producto Destacado con animación -->
              <?php if ($producto['destacado']): ?>
                <div class="absolute top-4 left-4 bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg animate-shimmer">
                  ⭐ Producto Destacado
                </div>
              <?php endif; ?>
              
              <!-- Badge de stock -->
              <div class="absolute top-4 right-4 <?= $producto['stock'] > 0 ? 'bg-green-500' : 'bg-red-500' ?> text-white px-3 py-1 rounded-full text-xs font-medium shadow-lg">
                <?= $producto['stock'] > 0 ? '✅ En Stock' : '❌ Sin Stock' ?>
              </div>
              
              <!-- Overlay con efectos mejorados -->
              <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500"></div>
              
              <!-- Botones de acción rápida en hover -->
              <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300">
                <div class="flex space-x-3">
                  <button class="bg-white/90 backdrop-blur-sm text-gray-800 p-3 rounded-full shadow-lg hover:scale-110 transition-transform">
                    🔍
                  </button>
                  <button class="bg-white/90 backdrop-blur-sm text-gray-800 p-3 rounded-full shadow-lg hover:scale-110 transition-transform">
                    ❤️
                  </button>
                  <button onclick="shareProduct()" class="bg-white/90 backdrop-blur-sm text-gray-800 p-3 rounded-full shadow-lg hover:scale-110 transition-transform">
                    📤
                  </button>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Miniaturas mejoradas -->
          <?php if (count($producto['imagenes']) > 1): ?>
            <div class="grid grid-cols-4 gap-3 mt-6">
              <?php foreach ($producto['imagenes'] as $index => $imagen): ?>
                <button class="aspect-square bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl overflow-hidden border-3 transition-all duration-300 hover-lift cursor-pointer <?= $index === 0 ? 'border-blue-500 shadow-lg' : 'border-gray-300 opacity-70 hover:opacity-100 hover:border-blue-400' ?>"
                        onclick="changeMainImage('<?= htmlspecialchars($imagen['url']) ?>', this, <?= $index ?>)">
                  <img src="<?= htmlspecialchars($imagen['url']) ?>" 
                       alt="<?= htmlspecialchars($producto['nombre']) ?>" 
                       class="w-full h-full object-cover">
                </button>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
          
          <!-- Videos -->
          <?php if (!empty($producto['videos'])): ?>
            <div class="mt-6">
              <h3 class="text-lg font-semibold text-gray-900 mb-3">Videos del producto</h3>
              <div class="space-y-4">
                <?php foreach ($producto['videos'] as $video): ?>
                  <div class="aspect-video bg-gray-100 rounded-xl overflow-hidden shadow-md">
                    <video controls class="w-full h-full">
                      <source src="<?= htmlspecialchars($video['url']) ?>" type="video/mp4">
                      Tu navegador no soporta el elemento de video.
                    </video>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endif; ?>
        <?php else: ?>
          <!-- Placeholder si no hay imágenes -->
          <div class="aspect-square bg-gray-100 rounded-2xl flex items-center justify-center">
            <div class="text-center text-gray-400">
              <i class="fas fa-image text-6xl mb-4"></i>
              <p>Sin imagen disponible</p>
            </div>
          </div>
        <?php endif; ?>
      </div>

      <!-- Información del producto -->
      <div class="space-y-6 fade-in-right">
        <!-- Elementos decorativos -->
        <div class="absolute -top-8 -right-8 w-32 h-32 bg-gradient-to-br from-blue-400/10 to-purple-600/10 rounded-full blur-2xl"></div>
        <div class="absolute -bottom-8 -left-8 w-24 h-24 bg-gradient-to-tr from-green-400/10 to-blue-600/10 rounded-full blur-xl"></div>
        
        <!-- Título y precio -->
        <div class="relative">
          <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-8 shadow-xl border border-gray-100">
            <?php if ($producto['destacado']): ?>
              <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 mb-3">
                <i class="fas fa-star mr-1"></i>
                Producto Destacado
              </div>
            <?php endif; ?>
            
            <h1 class="text-4xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent mb-6 typewriter leading-tight">
              <?= htmlspecialchars($producto['nombre']) ?>
            </h1>
            
            <div class="flex items-center space-x-6 mb-6">
              <div class="relative">
                <span class="text-5xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                  $<?= $producto['precio_formateado'] ?>
                </span>
                <div class="absolute -inset-2 bg-gradient-to-r from-blue-600/20 to-purple-600/20 rounded-lg blur-lg opacity-50"></div>
              </div>
              <div class="flex flex-col space-y-2">
                <?php if (isset($producto['categoria_nombre'])): ?>
                  <span class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-4 py-2 rounded-full text-sm font-medium shadow-lg hover:scale-105 transition-transform">
                    🎱 <?= htmlspecialchars($producto['categoria_nombre']) ?>
                  </span>
                <?php endif; ?>
                <div class="flex items-center space-x-2">
                  <div class="flex text-yellow-400">
                    ⭐⭐⭐⭐⭐
                  </div>
                  <span class="text-sm text-gray-600">(4.8/5)</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Estado del stock -->
        <div class="flex items-center space-x-2">
          <?php if ($producto['stock'] > 0): ?>
            <div class="flex items-center text-secondary-600">
              <i class="fas fa-check-circle mr-2"></i>
              <span class="font-medium">En stock</span>
              <span class="text-gray-500 ml-1">(<?= $producto['stock'] ?> disponibles)</span>
            </div>
          <?php else: ?>
            <div class="flex items-center text-red-600">
              <i class="fas fa-exclamation-circle mr-2"></i>
              <span class="font-medium">Sin stock disponible</span>
            </div>
          <?php endif; ?>
        </div>

        <!-- Descripción -->
        <div class="prose prose-gray max-w-none">
          <h3 class="text-lg font-semibold text-gray-900 mb-3">Descripción</h3>
          <p class="text-gray-700 leading-relaxed"><?= nl2br(htmlspecialchars($producto['descripcion'])) ?></p>
        </div>

        <!-- Botones de acción -->
        <div class="space-y-4">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <a href="https://wa.me/573188763377?text=Hola, me interesa el producto: <?= urlencode($producto['nombre']) ?> - $<?= $producto['precio_formateado'] ?>" 
               class="flex items-center justify-center px-6 py-3 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 transition-colors shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 duration-200"
               target="_blank">
              <i class="fab fa-whatsapp mr-2 text-lg"></i>
              Consultar por WhatsApp
            </a>
            
            <a href="https://wa.me/573188763377?text=Hola, quiero comprar: <?= urlencode($producto['nombre']) ?> - $<?= $producto['precio_formateado'] ?>" 
               target="_blank"
               class="flex items-center justify-center px-6 py-3 gradient-bg text-white font-semibold rounded-xl hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
              <i class="fas fa-shopping-cart mr-2"></i>
              Comprar Ahora
            </a>
          </div>
          
          <button onclick="shareProduct()"
                  class="w-full flex items-center justify-center px-6 py-3 border-2 border-primary-600 text-primary-600 font-semibold rounded-xl hover:bg-primary-50 transition-colors">
            <i class="fas fa-share-alt mr-2"></i>
            Compartir producto
          </button>
        </div>

        <!-- Información adicional -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 rounded-xl border border-blue-200">
          <h3 class="text-lg font-semibold text-blue-800 mb-4 flex items-center">
            <span class="mr-2">🎱</span>
            Información adicional
          </h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="flex items-center text-blue-700">
              <span class="w-2 h-2 bg-blue-500 rounded-full mr-3"></span>
              Envío a toda Colombia
            </div>
            <div class="flex items-center text-blue-700">
              <span class="w-2 h-2 bg-blue-500 rounded-full mr-3"></span>
              Garantía de fabricación
            </div>
            <div class="flex items-center text-blue-700">
              <span class="w-2 h-2 bg-blue-500 rounded-full mr-3"></span>
              Fabricación artesanal
            </div>
            <div class="flex items-center text-blue-700">
              <span class="w-2 h-2 bg-blue-500 rounded-full mr-3"></span>
              Asesoría especializada
            </div>
            <div class="flex items-center text-blue-700">
              <span class="w-2 h-2 bg-blue-500 rounded-full mr-3"></span>
              Materiales premium
            </div>
            <div class="flex items-center text-blue-700">
              <span class="w-2 h-2 bg-blue-500 rounded-full mr-3"></span>
              Personalización disponible
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Información adicional con tabs -->
<div class="bg-gray-50 border-t border-gray-200">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
      <!-- Tab navigation -->
      <div class="border-b border-gray-200">
        <nav class="flex space-x-8 px-6" aria-label="Tabs">
          <button onclick="showTab('ingredients')" 
                  class="tab-btn py-4 px-1 border-b-2 font-medium text-sm transition-colors border-primary-500 text-primary-600"
                  data-tab="ingredients">
            <i class="fas fa-cog mr-2"></i>
            Especificaciones
          </button>
          <button onclick="showTab('nutrition')" 
                  class="tab-btn py-4 px-1 border-b-2 font-medium text-sm transition-colors border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300"
                  data-tab="nutrition">
            <i class="fas fa-info-circle mr-2"></i>
            Características
          </button>
          <button onclick="showTab('delivery')" 
                  class="tab-btn py-4 px-1 border-b-2 font-medium text-sm transition-colors border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300"
                  data-tab="delivery">
            <i class="fas fa-truck mr-2"></i>
            Entrega
          </button>
        </nav>
      </div>
      
      <!-- Tab content -->
      <div class="p-6">
        <div id="ingredients" class="tab-pane animate-fade-in">
          <h3 class="text-xl font-semibold text-gray-900 mb-4">Especificaciones Técnicas</h3>
          <div class="prose prose-gray max-w-none">
            <p class="text-gray-700">Nuestros tacos de billar están fabricados con materiales de la más alta calidad y precisión:</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
              <div class="space-y-3">
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                  <span class="font-medium">Peso:</span>
                  <span class="text-primary-600 font-semibold">19 onz</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                  <span class="font-medium">Punta del casquillo:</span>
                  <span class="text-primary-600 font-semibold">11.5 mm</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                  <span class="font-medium">Material del shaft:</span>
                  <span class="text-primary-600 font-semibold">Madera premium</span>
                </div>
              </div>
              <div class="space-y-3">
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                  <span class="font-medium">Longitud:</span>
                  <span class="text-primary-600 font-semibold">147 cm</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                  <span class="font-medium">Tipo de rosca:</span>
                  <span class="text-primary-600 font-semibold">5/16 x 18</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                  <span class="font-medium">Acabado:</span>
                  <span class="text-primary-600 font-semibold">Lacado profesional</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <div id="nutrition" class="tab-pane hidden">
          <h3 class="text-xl font-semibold text-gray-900 mb-4">Características del Producto</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-50 rounded-lg p-4">
              <h4 class="font-semibold text-gray-900 mb-3">Características Principales</h4>
              <div class="space-y-2 text-sm">
                <div class="flex justify-between"><span>Nivel:</span><span class="font-medium">Profesional</span></div>
                <div class="flex justify-between"><span>Flexibilidad:</span><span class="font-medium">Media</span></div>
                <div class="flex justify-between"><span>Balance:</span><span class="font-medium">Perfecto</span></div>
                <div class="flex justify-between"><span>Grip:</span><span class="font-medium">Antideslizante</span></div>
                <div class="flex justify-between"><span>Durabilidad:</span><span class="font-medium">Alta</span></div>
                <div class="flex justify-between"><span>Garantía:</span><span class="font-medium">1 año</span></div>
              </div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
              <h4 class="font-semibold text-gray-900 mb-3">Ventajas</h4>
              <ul class="space-y-2 text-sm">
                <li class="flex items-center"><i class="fas fa-star text-yellow-500 mr-2"></i> Precisión excepcional</li>
                <li class="flex items-center"><i class="fas fa-shield-alt text-blue-500 mr-2"></i> Construcción resistente</li>
                <li class="flex items-center"><i class="fas fa-hand-paper text-green-500 mr-2"></i> Agarre cómodo</li>
              </ul>
            </div>
          </div>
        </div>
        
        <div id="delivery" class="tab-pane hidden">
          <h3 class="text-xl font-semibold text-gray-900 mb-4">Información de Entrega y Garantía</h3>
          <div class="space-y-4">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
              <div class="flex items-center mb-2">
                <i class="fas fa-shipping-fast text-blue-600 mr-2"></i>
                <h4 class="font-semibold text-blue-900">Envío Nacional</h4>
              </div>
              <p class="text-blue-800 text-sm">Entregamos a toda Colombia con embalaje especializado para proteger tu taco de billar. Tiempo de entrega: 2-5 días hábiles.</p>
            </div>
            
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
              <div class="flex items-center mb-2">
                <i class="fas fa-shield-alt text-green-600 mr-2"></i>
                <h4 class="font-semibold text-green-900">Garantía de Calidad</h4>
              </div>
              <div class="text-green-800 text-sm space-y-1">
                <p>• Garantía de fabricación: 1 año</p>
                <p>• Revisión de calidad antes del envío</p>
                <p>• Soporte técnico especializado</p>
                <p>• Cambios por defectos de fábrica</p>
              </div>
            </div>
            
            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
              <div class="flex items-center mb-2">
                <i class="fas fa-box text-purple-600 mr-2"></i>
                <h4 class="font-semibold text-purple-900">Incluye en la Compra</h4>
              </div>
              <div class="text-purple-800 text-sm space-y-1">
                <p>✅ Estuche rígido de protección</p>
                <p>✅ 2 tizas profesionales</p>
                <p>✅ Guante de billar</p>
                <p>✅ Protectores de rosca</p>
                <p>✅ Manual de cuidado y mantenimiento</p>
              </div>
            </div>
            
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
              <div class="flex items-center mb-2">
                <i class="fas fa-money-bill-wave text-yellow-600 mr-2"></i>
                <h4 class="font-semibold text-yellow-900">Opciones de Pago</h4>
              </div>
              <p class="text-yellow-800 text-sm">Aceptamos efectivo, transferencias bancarias, tarjetas de crédito y débito. Financiación disponible hasta 12 meses sin intereses.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Botón volver -->
<div class="bg-white border-t border-gray-200 py-8">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
    <a href="/productos" 
       class="inline-flex items-center px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition duration-300">
      <i class="fas fa-arrow-left mr-2"></i>
      Volver a productos
    </a>
  </div>
</div>

<script>
// Cambiar imagen principal
function changeMainImage(src, thumbnail, index) {
  const mainImage = document.getElementById('mainImage');
  mainImage.src = src;
  
  // Remover clases activas de todas las miniaturas
  document.querySelectorAll('button[onclick*="changeMainImage"]').forEach(btn => {
    btn.classList.remove('border-primary-500', 'ring-2', 'ring-primary-200');
    btn.classList.add('border-gray-200');
  });
  
  // Agregar clases activas a la miniatura seleccionada
  thumbnail.classList.remove('border-gray-200');
  thumbnail.classList.add('border-primary-500', 'ring-2', 'ring-primary-200');
}

// Mostrar tabs
function showTab(tabName) {
  // Ocultar todos los paneles de tabs
  document.querySelectorAll('.tab-pane').forEach(pane => {
    pane.classList.add('hidden');
    pane.classList.remove('animate-fade-in');
  });
  
  // Remover clases activas de todos los botones de tabs
  document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.classList.remove('border-primary-500', 'text-primary-600');
    btn.classList.add('border-transparent', 'text-gray-500');
  });
  
  // Mostrar el panel seleccionado
  const selectedPane = document.getElementById(tabName);
  selectedPane.classList.remove('hidden');
  selectedPane.classList.add('animate-fade-in');
  
  // Agregar clases activas al botón seleccionado
  const selectedBtn = document.querySelector(`[data-tab="${tabName}"]`);
  selectedBtn.classList.remove('border-transparent', 'text-gray-500');
  selectedBtn.classList.add('border-primary-500', 'text-primary-600');
}

function shareProduct() {
    if (navigator.share) {
        navigator.share({
            title: '<?= htmlspecialchars($producto['nombre']) ?>',
            text: '<?= htmlspecialchars(substr($producto['descripcion'], 0, 100)) ?>...',
            url: window.location.href
        });
    } else {
        // Fallback para navegadores que no soportan Web Share API
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(() => {
            alert('Enlace copiado al portapapeles');
        });
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
  // Configurar el primer tab como activo
  showTab('ingredients');
});
</script>

<!-- JSON-LD -->
<script type="application/ld+json">
{
 "@context":"https://schema.org",
 "@type":"Product",
 "name": <?= json_encode($producto['nombre']) ?>,
 "image": <?= json_encode(array_values(array_map(fn($x)=>$x['url'],$producto['imagenes'] ?? []))) ?>,
 "description": <?= json_encode(mb_substr(strip_tags($producto['descripcion']),0,280)) ?>,
 "sku":"SKU-<?= (int)$producto['id'] ?>",
 "offers":{"@type":"Offer","priceCurrency":"COP","price":"<?= number_format($producto['precio'],2,'.','') ?>","availability":"https://schema.org/<?= $producto['stock']>0?'InStock':'OutOfStock' ?>"}
}
</script>
