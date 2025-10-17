<!doctype html>
<html lang="es" class="scroll-smooth">
<head>
  <meta charset="utf-8">
  <title><?= isset($title)?$title.' | ':'' ?>Tacos Capital</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="<?= isset($description) ? $description : 'Los mejores tacos de la ciudad. Ingredientes frescos, sabores auténticos y la mejor experiencia gastronómica.' ?>">
  
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: {
              50: '#fef7ee',
              100: '#fdedd3',
              200: '#fbd7a5',
              300: '#f8bb6d',
              400: '#f59532',
              500: '#f2760a',
              600: '#e35d05',
              700: '#bc4508',
              800: '#95370e',
              900: '#782f0f',
            },
            secondary: {
              50: '#f0fdf4',
              100: '#dcfce7',
              200: '#bbf7d0',
              300: '#86efac',
              400: '#4ade80',
              500: '#22c55e',
              600: '#16a34a',
              700: '#15803d',
              800: '#166534',
              900: '#14532d',
            }
          },
          fontFamily: {
            'sans': ['Inter', 'system-ui', 'sans-serif'],
          },
          animation: {
            'fade-in': 'fadeIn 0.5s ease-in-out',
            'slide-up': 'slideUp 0.3s ease-out',
            'zoom-in': 'zoomIn 0.2s ease-out',
          },
          keyframes: {
            fadeIn: {
              '0%': { opacity: '0' },
              '100%': { opacity: '1' },
            },
            slideUp: {
              '0%': { transform: 'translateY(10px)', opacity: '0' },
              '100%': { transform: 'translateY(0)', opacity: '1' },
            },
            zoomIn: {
              '0%': { transform: 'scale(0.95)', opacity: '0' },
              '100%': { transform: 'scale(1)', opacity: '1' },
            },
          }
        }
      }
    }
  </script>
  
  <!-- Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <!-- PWA -->
  <link rel="manifest" href="/manifest.webmanifest">
  <meta name="theme-color" content="#f2760a">
  
  <!-- HTMX -->
  <script src="https://unpkg.com/htmx.org@1.9.12"></script>
  
  <!-- Custom styles -->
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
    
    :root {
      --primary-50: #fef7ee;
      --primary-100: #fdedd3;
      --primary-200: #fbd7a5;
      --primary-300: #f8bb6d;
      --primary-400: #f59333;
      --primary-500: #f3740b;
      --primary-600: #e45a06;
      --primary-700: #bd4309;
      --primary-800: #973610;
      --primary-900: #7a2e11;
    }
    
    .gradient-bg {
      background: #2563eb;
    }
    

    

    

    
    /* Efectos hover mejorados */
    .hover-lift {
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .hover-lift:hover {
      transform: translateY(-12px) scale(1.02);
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    
    .hover-glow:hover {
      box-shadow: 0 0 20px rgba(59, 130, 246, 0.6);
      transform: scale(1.05);
    }
    
    .hover-rotate:hover {
      transform: rotate(5deg) scale(1.1);
    }
    

    
    /* Smooth scrolling */
    html {
      scroll-behavior: smooth;
    }
    

    
    /* Micro-interacciones para botones */
    .btn-interactive {
      position: relative;
      overflow: hidden;
      transition: all 0.3s ease;
    }
    
    .btn-interactive::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      background: rgba(255, 255, 255, 0.2);
      border-radius: 50%;
      transform: translate(-50%, -50%);
      transition: width 0.6s, height 0.6s;
    }
    
    .btn-interactive:hover::before {
      width: 300px;
      height: 300px;
    }
    
    /* Efectos de entrada para elementos */
    .fade-in-up {
      opacity: 0;
      transform: translateY(30px);
      transition: all 0.6s ease;
    }
    
    .fade-in-up.visible {
      opacity: 1;
      transform: translateY(0);
    }
    
    /* Parallax suave */
    .parallax {
      transform: translateZ(0);
      will-change: transform;
    }
  </style>
</head>
<body class="bg-gray-50 font-sans antialiased">
  <!-- Header -->
  <header class="bg-white sticky top-0 z-50 border-b border-gray-200">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-20">
        <!-- Logo -->
        <div class="flex items-center space-x-4">
          <div class="w-12 h-12 bg-blue-600 rounded flex items-center justify-center">
            <span class="text-white font-bold text-2xl">🎱</span>
          </div>
          <div>
            <h1 class="text-2xl font-bold text-gray-900">
              Tacos Capital
            </h1>
            <p class="text-sm text-gray-600 font-medium">Tacos de Billar Profesionales</p>
          </div>
        </div>
        
        <!-- Navigation -->
        <nav class="hidden md:flex items-center space-x-2">
          <a href="/" class="px-4 py-2 rounded font-medium <?= $_SERVER['REQUEST_URI'] === '/' ? 'text-blue-600 bg-blue-50' : 'text-gray-700 hover:text-blue-600' ?>">
            Inicio
          </a>
          <a href="/productos" class="px-4 py-2 rounded font-medium <?= strpos($_SERVER['REQUEST_URI'], '/productos') === 0 ? 'text-blue-600 bg-blue-50' : 'text-gray-700 hover:text-blue-600' ?>">
            Productos
          </a>
          <a href="https://wa.me/573188763377" target="_blank" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded font-medium transition-colors">
            <i class="fab fa-whatsapp mr-2"></i>
            Contactar
          </a>
        </nav>
        
        <!-- Mobile menu button -->
        <button class="md:hidden p-2 rounded text-gray-700 hover:text-blue-600" onclick="toggleMobileMenu()">
          <i class="fas fa-bars text-xl"></i>
        </button>
      </div>
      
      <!-- Mobile Navigation -->
      <div id="mobile-menu" class="hidden md:hidden pb-4">
        <div class="space-y-2">
          <a href="/" class="block px-4 py-2 rounded font-medium <?= $_SERVER['REQUEST_URI'] === '/' ? 'text-blue-600 bg-blue-50' : 'text-gray-700 hover:text-blue-600' ?>">
            Inicio
          </a>
          <a href="/productos" class="block px-4 py-2 rounded font-medium <?= strpos($_SERVER['REQUEST_URI'], '/productos') === 0 ? 'text-blue-600 bg-blue-50' : 'text-gray-700 hover:text-blue-600' ?>">
            Productos
          </a>
          <a href="https://wa.me/573188763377" target="_blank" class="block bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded font-medium transition-colors">
            <i class="fab fa-whatsapp mr-2"></i>
            Contactar
          </a>
        </div>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <main class="min-h-screen">
    <?=$this->section('content')?>
  </main>

  <!-- Footer -->
  <footer class="bg-gray-900 text-white">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <!-- Logo y descripción -->
        <div class="col-span-1 md:col-span-2">
          <div class="flex items-center space-x-4 mb-6">
            <div class="w-14 h-14 bg-blue-600 rounded flex items-center justify-center">
              <span class="text-white font-bold text-3xl">🎱</span>
            </div>
            <div>
              <h3 class="text-2xl font-bold text-white">
                Tacos Capital
              </h3>
              <p class="text-blue-400 font-medium">Tacos de Billar Profesionales</p>
            </div>
          </div>
          <p class="text-gray-300 mb-6 text-lg leading-relaxed">
            Especialistas en tacos de billar de alta calidad. Fabricación artesanal con los mejores materiales 
            para jugadores profesionales y aficionados exigentes.
          </p>
          <div class="flex space-x-6">
            <a href="#" class="text-gray-400 hover:text-blue-400">
              <i class="fab fa-facebook text-2xl"></i>
            </a>
            <a href="#" class="text-gray-400 hover:text-blue-400">
              <i class="fab fa-instagram text-2xl"></i>
            </a>
            <a href="#" class="text-gray-400 hover:text-blue-400">
              <i class="fab fa-whatsapp text-2xl"></i>
            </a>
          </div>
        </div>

        <!-- Enlaces -->
        <div>
          <h4 class="text-xl font-bold mb-6 text-white">Enlaces Rápidos</h4>
          <ul class="space-y-3">
            <li><a href="/" class="text-gray-300 hover:text-blue-400">🏠 Inicio</a></li>
            <li><a href="/productos" class="text-gray-300 hover:text-blue-400">🎱 Productos</a></li>
            <li><a href="/checkout" class="text-gray-300 hover:text-blue-400">🛒 Carrito</a></li>
            <li><a href="/admin" class="text-gray-300 hover:text-blue-400">⚙️ Admin</a></li>
          </ul>
        </div>

        <!-- Contacto -->
        <div>
          <h4 class="text-xl font-bold mb-6 text-white">Contacto</h4>
          <ul class="space-y-4 text-gray-300">
            <li class="flex items-center space-x-3 hover:text-blue-400">
              <i class="fas fa-phone text-blue-400"></i>
              <span>+57 300 123 4567</span>
            </li>
            <li class="flex items-center space-x-3 hover:text-blue-400">
              <i class="fas fa-envelope text-blue-400"></i>
              <span>info@tacoscapital.com</span>
            </li>
            <li class="flex items-center space-x-3 hover:text-blue-400">
              <i class="fas fa-map-marker-alt text-blue-400"></i>
              <span>Bogotá, Colombia</span>
            </li>
            <li class="flex items-center space-x-3 hover:text-blue-400">
              <i class="fas fa-clock text-blue-400"></i>
              <span>Lun - Sáb: 9AM - 7PM</span>
            </li>
          </ul>
        </div>
      </div>

      <div class="border-t border-gray-700 mt-12 pt-8">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
          <p class="text-gray-400 text-center md:text-left">
            &copy; 2025 Tacos Capital. Todos los derechos reservados.
          </p>
          <div class="flex space-x-6 text-sm text-gray-400">
            <a href="#" class="hover:text-blue-400">Política de Privacidad</a>
            <a href="#" class="hover:text-blue-400">Términos de Servicio</a>
            <a href="#" class="hover:text-blue-400">Garantías</a>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <script>
    if ('serviceWorker' in navigator) {
      navigator.serviceWorker.register('/service-worker.js').catch(()=>{});
    }
    
    // Mobile menu toggle
    document.addEventListener('DOMContentLoaded', function() {
      const mobileMenuButton = document.querySelector('button[class*="md:hidden"]');
      if (mobileMenuButton) {
        mobileMenuButton.addEventListener('click', function() {
          // Add mobile menu functionality here
          console.log('Mobile menu clicked');
        });
      }
    });
    
    // Intersection Observer para animaciones de entrada
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                
                // Añadir delay escalonado para múltiples elementos
                const delay = Array.from(entry.target.parentNode.children).indexOf(entry.target) * 100;
                setTimeout(() => {
                    entry.target.style.transitionDelay = delay + 'ms';
                }, delay);
            }
        });
    }, observerOptions);

    // Observar elementos con clase fade-in-up
    document.addEventListener('DOMContentLoaded', () => {
        const fadeElements = document.querySelectorAll('.fade-in-up, .fade-in-left, .fade-in-right');
        fadeElements.forEach(el => observer.observe(el));
        
        // Efectos hover mejorados en cards
        const cards = document.querySelectorAll('.group, .hover-lift, .card-hover');
        cards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-12px) scale(1.02)';
                card.style.boxShadow = '0 25px 50px -12px rgba(0, 0, 0, 0.25)';
                
                // Añadir efecto glow si tiene la clase
                if (card.classList.contains('hover-glow')) {
                    card.style.boxShadow += ', 0 0 20px rgba(59, 130, 246, 0.6)';
                }
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0) scale(1)';
                card.style.boxShadow = '';
            });
        });
        
        // Efecto parallax mejorado en scroll
        let ticking = false;
        
        function updateParallax() {
            const scrolled = window.pageYOffset;
            const parallaxElements = document.querySelectorAll('.parallax');
            
            parallaxElements.forEach(element => {
                const speed = element.dataset.speed || 0.5;
                const yPos = -(scrolled * speed);
                element.style.transform = `translate3d(0, ${yPos}px, 0)`;
            });
            
            ticking = false;
        }
        
        function requestTick() {
            if (!ticking) {
                requestAnimationFrame(updateParallax);
                ticking = true;
            }
        }
        
        window.addEventListener('scroll', requestTick);
        
        // Smooth scroll para enlaces internos
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        

        
        // Lazy loading mejorado para imágenes
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('loading');
                    img.classList.add('loaded');
                    imageObserver.unobserve(img);
                }
            });
        });
        
        document.querySelectorAll('img[data-src]').forEach(img => {
            img.classList.add('loading');
            imageObserver.observe(img);
        });
        
        // Efectos de typing para texto
        function typeWriter(element, text, speed = 50) {
            let i = 0;
            element.innerHTML = '';
            function type() {
                if (i < text.length) {
                    element.innerHTML += text.charAt(i);
                    i++;
                    setTimeout(type, speed);
                }
            }
            type();
        }

        // Aplicar efecto typing a elementos con clase 'typewriter'
        document.querySelectorAll('.typewriter').forEach(element => {
            const text = element.textContent;
            const typeObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        typeWriter(element, text);
                        typeObserver.unobserve(element);
                    }
                });
            });
            typeObserver.observe(element);
        });

        // Efecto de contador animado
        function animateCounter(element, target, duration = 2000) {
            let start = 0;
            const increment = target / (duration / 16);
            
            function updateCounter() {
                start += increment;
                if (start < target) {
                    element.textContent = Math.floor(start);
                    requestAnimationFrame(updateCounter);
                } else {
                    element.textContent = target;
                }
            }
            updateCounter();
        }

        // Aplicar contador a elementos con clase 'counter'
        document.querySelectorAll('.counter').forEach(element => {
            const target = parseInt(element.dataset.target);
            const counterObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateCounter(element, target);
                        counterObserver.unobserve(element);
                    }
                });
            });
            counterObserver.observe(element);
        });



        // Efecto de cursor personalizado
        const cursor = document.createElement('div');
        cursor.className = 'custom-cursor';
        cursor.style.cssText = `
            position: fixed;
            width: 20px;
            height: 20px;
            background: rgba(59, 130, 246, 0.5);
            border-radius: 50%;
            pointer-events: none;
            z-index: 9999;
            transition: transform 0.1s ease;
            display: none;
        `;
        document.body.appendChild(cursor);

        document.addEventListener('mousemove', (e) => {
            cursor.style.display = 'block';
            cursor.style.left = e.clientX - 10 + 'px';
            cursor.style.top = e.clientY - 10 + 'px';
        });

        // Efecto de scroll reveal para navegación
        let lastScrollTop = 0;
        const header = document.querySelector('header');
        
        window.addEventListener('scroll', function() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            if (scrollTop > lastScrollTop && scrollTop > 100) {
                // Scrolling down
                header.style.transform = 'translateY(-100%)';
            } else {
                // Scrolling up
                header.style.transform = 'translateY(0)';
            }
            
            lastScrollTop = scrollTop;
        });
    });
    
    // Preloader mejorado
    window.addEventListener('load', () => {
        document.body.classList.add('loaded');
        const preloader = document.getElementById('preloader');
        if (preloader) {
            setTimeout(() => {
                preloader.style.opacity = '0';
                preloader.style.transform = 'scale(0.8)';
                setTimeout(() => {
                    preloader.style.display = 'none';
                }, 300);
            }, 1000);
        }
    });
    
    // CSS adicional para nuevas animaciones
    const additionalStyles = document.createElement('style');
    additionalStyles.textContent = `

        
        .loaded {
            opacity: 1;
            transform: scale(1);
            transition: all 0.3s ease;
        }
        
        .custom-cursor {
            mix-blend-mode: difference;
        }
        

        

        

    `;
    
    document.head.appendChild(additionalStyles);
    
    // Función para el menú móvil
    function toggleMobileMenu() {
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenu.classList.toggle('hidden');
    }
  </script>

  <!-- Botón flotante de WhatsApp - SIEMPRE VISIBLE -->
  <div id="whatsapp-float-btn" class="whatsapp-float-container">
    <a href="https://wa.me/573188763377?text=Hola, me gustaría información sobre sus tacos de billar" target="_blank" 
       class="whatsapp-btn">
      <i class="fab fa-whatsapp"></i>
    </a>
    <!-- Tooltip -->
    <div class="whatsapp-tooltip">
      ¡Contáctanos!
      <div class="tooltip-arrow"></div>
    </div>
  </div>

  <style>
    /* Botón de WhatsApp flotante - MÁXIMA PRIORIDAD */
    #whatsapp-float-btn.whatsapp-float-container {
      position: fixed !important;
      bottom: 20px !important;
      right: 20px !important;
      z-index: 999999 !important;
      pointer-events: auto !important;
      display: block !important;
      visibility: visible !important;
      opacity: 1 !important;
      transform: none !important;
      margin: 0 !important;
      padding: 0 !important;
      top: auto !important;
      left: auto !important;
      width: auto !important;
      height: auto !important;
      background: none !important;
      border: none !important;
      box-shadow: none !important;
    }
    
    #whatsapp-float-btn .whatsapp-btn {
      display: flex !important;
      align-items: center !important;
      justify-content: center !important;
      width: 60px !important;
      height: 60px !important;
      background: linear-gradient(135deg, #25d366 0%, #128c7e 100%) !important;
      border-radius: 50% !important;
      box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4) !important;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
      text-decoration: none !important;
      animation: whatsapp-pulse-fixed 2s infinite !important;
      position: relative !important;
      top: auto !important;
      left: auto !important;
      right: auto !important;
      bottom: auto !important;
      margin: 0 !important;
      padding: 0 !important;
      transform: none !important;
    }
    
    #whatsapp-float-btn .whatsapp-btn:hover {
      transform: scale(1.1) translateY(-2px) !important;
      box-shadow: 0 8px 30px rgba(37, 211, 102, 0.6) !important;
      background: linear-gradient(135deg, #128c7e 0%, #25d366 100%) !important;
    }
    
    #whatsapp-float-btn .whatsapp-btn i {
      font-size: 28px !important;
      color: white !important;
      position: relative !important;
      z-index: 1 !important;
    }
    
    #whatsapp-float-btn .whatsapp-tooltip {
      position: absolute !important;
      bottom: 70px !important;
      right: 0 !important;
      background: rgba(0, 0, 0, 0.8) !important;
      color: white !important;
      padding: 8px 12px !important;
      border-radius: 8px !important;
      font-size: 14px !important;
      font-weight: 500 !important;
      white-space: nowrap !important;
      opacity: 0 !important;
      transform: translateY(10px) !important;
      transition: all 0.3s ease !important;
      pointer-events: none !important;
      z-index: 999999 !important;
    }
    
    #whatsapp-float-btn:hover .whatsapp-tooltip {
      opacity: 1 !important;
      transform: translateY(0) !important;
    }
    
    #whatsapp-float-btn .tooltip-arrow {
      position: absolute !important;
      top: 100% !important;
      right: 20px !important;
      width: 0 !important;
      height: 0 !important;
      border-left: 6px solid transparent !important;
      border-right: 6px solid transparent !important;
      border-top: 6px solid rgba(0, 0, 0, 0.8) !important;
    }
    
    @keyframes whatsapp-pulse-fixed {
      0% {
        box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4);
        transform: scale(1);
      }
      50% {
        box-shadow: 0 4px 20px rgba(37, 211, 102, 0.8), 0 0 0 10px rgba(37, 211, 102, 0.1);
        transform: scale(1.02);
      }
      100% {
        box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4);
        transform: scale(1);
      }
    }
    
    /* Asegurar que el botón esté siempre visible en móviles */
    @media (max-width: 768px) {
      #whatsapp-float-btn.whatsapp-float-container {
        bottom: 15px !important;
        right: 15px !important;
      }
      
      #whatsapp-float-btn .whatsapp-btn {
        width: 55px !important;
        height: 55px !important;
      }
      
      #whatsapp-float-btn .whatsapp-btn i {
        font-size: 24px !important;
      }
    }
  </style>

  <script>
    // JavaScript para forzar la posición del botón de WhatsApp
    document.addEventListener('DOMContentLoaded', function() {
      function forceWhatsAppPosition() {
        const whatsappBtn = document.getElementById('whatsapp-float-btn');
        if (whatsappBtn) {
          // Forzar estilos críticos
          whatsappBtn.style.setProperty('position', 'fixed', 'important');
          whatsappBtn.style.setProperty('bottom', '20px', 'important');
          whatsappBtn.style.setProperty('right', '20px', 'important');
          whatsappBtn.style.setProperty('z-index', '999999', 'important');
          whatsappBtn.style.setProperty('display', 'block', 'important');
          whatsappBtn.style.setProperty('visibility', 'visible', 'important');
          whatsappBtn.style.setProperty('opacity', '1', 'important');
          whatsappBtn.style.setProperty('transform', 'none', 'important');
          whatsappBtn.style.setProperty('top', 'auto', 'important');
          whatsappBtn.style.setProperty('left', 'auto', 'important');
          
          // Verificar en móviles
          if (window.innerWidth <= 768) {
            whatsappBtn.style.setProperty('bottom', '15px', 'important');
            whatsappBtn.style.setProperty('right', '15px', 'important');
          }
        }
      }
      
      // Ejecutar inmediatamente
      forceWhatsAppPosition();
      
      // Ejecutar después de un pequeño delay
      setTimeout(forceWhatsAppPosition, 100);
      setTimeout(forceWhatsAppPosition, 500);
      setTimeout(forceWhatsAppPosition, 1000);
      
      // Ejecutar en resize
      window.addEventListener('resize', forceWhatsAppPosition);
      
      // Ejecutar en scroll (por si acaso)
      let scrollTimeout;
      window.addEventListener('scroll', function() {
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(forceWhatsAppPosition, 50);
      });
      
      // Observer para detectar cambios en el DOM
      const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
          if (mutation.type === 'attributes' && mutation.target.id === 'whatsapp-float-btn') {
            setTimeout(forceWhatsAppPosition, 10);
          }
        });
      });
      
      const whatsappBtn = document.getElementById('whatsapp-float-btn');
      if (whatsappBtn) {
        observer.observe(whatsappBtn, {
          attributes: true,
          attributeFilter: ['style', 'class']
        });
      }
    });
  </script>
</body>
</html>
