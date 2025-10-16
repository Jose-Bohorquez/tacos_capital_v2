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
    
    .glass-effect {
      backdrop-filter: blur(10px);
      background: rgba(255, 255, 255, 0.1);
    }
    
    .gradient-bg {
      background: linear-gradient(135deg, var(--primary-500) 0%, var(--primary-700) 100%);
    }
    
    .text-shadow {
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }
    
    .image-zoom {
      transition: transform 0.3s ease;
    }
    
    .image-zoom:hover {
      transform: scale(1.05);
    }
    
    /* Animaciones principales */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes slideUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes pulse {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.5; }
    }
    
    @keyframes bounce {
      0%, 20%, 53%, 80%, 100% { transform: translate3d(0,0,0); }
      40%, 43% { transform: translate3d(0,-30px,0); }
      70% { transform: translate3d(0,-15px,0); }
      90% { transform: translate3d(0,-4px,0); }
    }
    
    @keyframes shimmer {
      0% { background-position: -200px 0; }
      100% { background-position: calc(200px + 100%) 0; }
    }
    
    @keyframes slideDown {
      from { transform: translateY(-100%); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }
    
    @keyframes slideInLeft {
      from { transform: translateX(-100%); opacity: 0; }
      to { transform: translateX(0); opacity: 1; }
    }
    
    @keyframes slideInRight {
      from { transform: translateX(100%); opacity: 0; }
      to { transform: translateX(0); opacity: 1; }
    }
    
    @keyframes fadeInScale {
      from { transform: scale(0.8); opacity: 0; }
      to { transform: scale(1); opacity: 1; }
    }
    
    @keyframes float {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-20px); }
    }
    
    @keyframes glow {
      0%, 100% { box-shadow: 0 0 5px rgba(59, 130, 246, 0.5); }
      50% { box-shadow: 0 0 20px rgba(59, 130, 246, 0.8), 0 0 30px rgba(59, 130, 246, 0.6); }
    }
    
    @keyframes rotate360 {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }
    
    @keyframes wiggle {
      0%, 7% { transform: rotateZ(0); }
      15% { transform: rotateZ(-15deg); }
      20% { transform: rotateZ(10deg); }
      25% { transform: rotateZ(-10deg); }
      30% { transform: rotateZ(6deg); }
      35% { transform: rotateZ(-4deg); }
      40%, 100% { transform: rotateZ(0); }
    }
    
    .animate-fade-in {
      animation: fadeIn 0.8s ease-out;
    }
    
    .animate-slide-up {
      animation: slideUp 1s ease-out 0.3s both;
    }
    
    .animate-slide-down {
      animation: slideDown 0.6s ease-out;
    }
    
    .animate-slide-in-left {
      animation: slideInLeft 0.6s ease-out;
    }
    
    .animate-slide-in-right {
      animation: slideInRight 0.6s ease-out;
    }
    
    .animate-fade-in-scale {
      animation: fadeInScale 0.6s ease-out;
    }
    
    .animate-float {
      animation: float 3s ease-in-out infinite;
    }
    
    .animate-glow {
      animation: glow 2s ease-in-out infinite;
    }
    
    .animate-spin-slow {
      animation: rotate360 3s linear infinite;
    }
    
    .animate-wiggle {
      animation: wiggle 1s ease-in-out;
    }
    
    .animate-pulse {
      animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    .animate-bounce {
      animation: bounce 1s infinite;
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
    
    .shimmer {
      background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
      background-size: 200px 100%;
      animation: shimmer 1.5s infinite;
    }
    
    /* Smooth scrolling */
    html {
      scroll-behavior: smooth;
    }
    
    /* Loading states */
    .loading {
      position: relative;
      overflow: hidden;
    }
    
    .loading::after {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
      animation: shimmer 1.5s infinite;
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
  <header class="glass-effect sticky top-0 z-50 border-b border-white/20 animate-slide-down">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-20">
        <!-- Logo -->
        <div class="flex items-center space-x-4 group">
          <div class="w-12 h-12 gradient-bg rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300 group-hover:scale-110">
            <span class="text-white font-bold text-2xl">🎱</span>
          </div>
          <div class="group-hover:transform group-hover:scale-105 transition-transform duration-300">
            <h1 class="text-2xl font-bold text-gray-900 bg-gradient-to-r from-primary-600 to-primary-800 bg-clip-text text-transparent">
              Tacos Capital
            </h1>
            <p class="text-sm text-gray-600 font-medium">Tacos de Billar Profesionales</p>
          </div>
        </div>
        
        <!-- Navigation -->
        <nav class="hidden md:flex items-center space-x-2">
          <a href="/" class="nav-link group relative px-4 py-2 rounded-xl font-medium transition-all duration-300 hover:bg-primary-50">
            <span class="relative z-10 text-gray-700 group-hover:text-primary-600 transition-colors duration-300">Inicio</span>
            <div class="absolute inset-0 bg-gradient-to-r from-primary-500 to-primary-600 rounded-xl opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
          </a>
          <a href="/productos" class="nav-link group relative px-4 py-2 rounded-xl font-medium transition-all duration-300 hover:bg-primary-50">
            <span class="relative z-10 text-gray-700 group-hover:text-primary-600 transition-colors duration-300">Productos</span>
            <div class="absolute inset-0 bg-gradient-to-r from-primary-500 to-primary-600 rounded-xl opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
          </a>
          <a href="/checkout" class="nav-link group relative px-4 py-2 rounded-xl font-medium transition-all duration-300 hover:bg-primary-50">
            <span class="relative z-10 text-gray-700 group-hover:text-primary-600 transition-colors duration-300">Carrito</span>
            <span class="absolute -top-1 -right-1 bg-gradient-to-r from-red-500 to-red-600 text-white text-xs rounded-full w-6 h-6 flex items-center justify-center shadow-lg animate-pulse">
              0
            </span>
            <div class="absolute inset-0 bg-gradient-to-r from-primary-500 to-primary-600 rounded-xl opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
          </a>
          <a href="/admin" class="nav-link group relative px-4 py-2 rounded-xl font-medium transition-all duration-300 hover:bg-primary-50">
            <span class="relative z-10 text-gray-700 group-hover:text-primary-600 transition-colors duration-300">Admin</span>
            <div class="absolute inset-0 bg-gradient-to-r from-primary-500 to-primary-600 rounded-xl opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
          </a>
        </nav>
        
        <!-- Mobile menu button -->
        <button class="md:hidden p-2 rounded-lg text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-colors">
          <i class="fas fa-bars text-xl"></i>
        </button>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <main class="min-h-screen">
    <?=$this->section('content')?>
  </main>

  <!-- Footer -->
  <footer class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white relative overflow-hidden">
    <!-- Decorative elements -->
    <div class="absolute inset-0 opacity-10">
      <div class="absolute top-10 left-10 w-32 h-32 bg-primary-500 rounded-full blur-3xl animate-pulse"></div>
      <div class="absolute bottom-10 right-10 w-24 h-24 bg-blue-500 rounded-full blur-2xl animate-pulse delay-1000"></div>
      <div class="absolute top-1/2 left-1/3 w-16 h-16 bg-green-500 rounded-full blur-xl animate-pulse delay-500"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <!-- Logo y descripción -->
        <div class="col-span-1 md:col-span-2">
          <div class="flex items-center space-x-4 mb-6 group">
            <div class="w-14 h-14 gradient-bg rounded-2xl flex items-center justify-center shadow-2xl group-hover:shadow-primary-500/25 transition-all duration-300 group-hover:scale-110">
              <span class="text-white font-bold text-3xl">🎱</span>
            </div>
            <div>
              <h3 class="text-2xl font-bold bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent">
                Tacos Capital
              </h3>
              <p class="text-primary-400 font-medium">Tacos de Billar Profesionales</p>
            </div>
          </div>
          <p class="text-gray-300 mb-6 text-lg leading-relaxed">
            Especialistas en tacos de billar de alta calidad. Fabricación artesanal con los mejores materiales 
            para jugadores profesionales y aficionados exigentes.
          </p>
          <div class="flex space-x-6">
            <a href="#" class="text-gray-400 hover:text-primary-400 transition-all duration-300 hover:scale-125 transform">
              <i class="fab fa-facebook text-2xl"></i>
            </a>
            <a href="#" class="text-gray-400 hover:text-primary-400 transition-all duration-300 hover:scale-125 transform">
              <i class="fab fa-instagram text-2xl"></i>
            </a>
            <a href="#" class="text-gray-400 hover:text-primary-400 transition-all duration-300 hover:scale-125 transform">
              <i class="fab fa-whatsapp text-2xl"></i>
            </a>
          </div>
        </div>

        <!-- Enlaces -->
        <div>
          <h4 class="text-xl font-bold mb-6 text-white">Enlaces Rápidos</h4>
          <ul class="space-y-3">
            <li><a href="/" class="text-gray-300 hover:text-primary-400 transition-all duration-300 hover:translate-x-2 transform inline-block">🏠 Inicio</a></li>
            <li><a href="/productos" class="text-gray-300 hover:text-primary-400 transition-all duration-300 hover:translate-x-2 transform inline-block">🎱 Productos</a></li>
            <li><a href="/checkout" class="text-gray-300 hover:text-primary-400 transition-all duration-300 hover:translate-x-2 transform inline-block">🛒 Carrito</a></li>
            <li><a href="/admin" class="text-gray-300 hover:text-primary-400 transition-all duration-300 hover:translate-x-2 transform inline-block">⚙️ Admin</a></li>
          </ul>
        </div>

        <!-- Contacto -->
        <div>
          <h4 class="text-xl font-bold mb-6 text-white">Contacto</h4>
          <ul class="space-y-4 text-gray-300">
            <li class="flex items-center space-x-3 hover:text-primary-400 transition-colors duration-300">
              <i class="fas fa-phone text-primary-400"></i>
              <span>+57 300 123 4567</span>
            </li>
            <li class="flex items-center space-x-3 hover:text-primary-400 transition-colors duration-300">
              <i class="fas fa-envelope text-primary-400"></i>
              <span>info@tacoscapital.com</span>
            </li>
            <li class="flex items-center space-x-3 hover:text-primary-400 transition-colors duration-300">
              <i class="fas fa-map-marker-alt text-primary-400"></i>
              <span>Bogotá, Colombia</span>
            </li>
            <li class="flex items-center space-x-3 hover:text-primary-400 transition-colors duration-300">
              <i class="fas fa-clock text-primary-400"></i>
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
            <a href="#" class="hover:text-primary-400 transition-colors duration-300">Política de Privacidad</a>
            <a href="#" class="hover:text-primary-400 transition-colors duration-300">Términos de Servicio</a>
            <a href="#" class="hover:text-primary-400 transition-colors duration-300">Garantías</a>
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
        
        // Efecto ripple mejorado en botones
        document.querySelectorAll('.btn-interactive').forEach(button => {
            button.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.cssText = `
                    position: absolute;
                    width: ${size}px;
                    height: ${size}px;
                    left: ${x}px;
                    top: ${y}px;
                    background: radial-gradient(circle, rgba(255,255,255,0.6) 0%, transparent 70%);
                    border-radius: 50%;
                    transform: scale(0);
                    animation: ripple-effect 0.6s ease-out;
                    pointer-events: none;
                `;
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
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

        // Efecto de partículas flotantes
        function createFloatingParticles() {
            const container = document.querySelector('.particles-container');
            if (!container) return;

            for (let i = 0; i < 20; i++) {
                const particle = document.createElement('div');
                particle.className = 'floating-particle';
                particle.style.cssText = `
                    position: absolute;
                    width: ${Math.random() * 6 + 2}px;
                    height: ${Math.random() * 6 + 2}px;
                    background: rgba(59, 130, 246, ${Math.random() * 0.5 + 0.1});
                    border-radius: 50%;
                    left: ${Math.random() * 100}%;
                    top: ${Math.random() * 100}%;
                    animation: float ${Math.random() * 3 + 2}s ease-in-out infinite;
                    animation-delay: ${Math.random() * 2}s;
                `;
                container.appendChild(particle);
            }
        }

        // Crear partículas si existe el contenedor
        createFloatingParticles();

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
        @keyframes ripple-effect {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
        
        .loaded {
            opacity: 1;
            transform: scale(1);
            transition: all 0.3s ease;
        }
        
        .custom-cursor {
            mix-blend-mode: difference;
        }
        
        header {
            transition: transform 0.3s ease;
        }
        
        .floating-particle {
            pointer-events: none;
        }
        
        .fade-in-left {
            opacity: 0;
            transform: translateX(-30px);
            transition: all 0.6s ease;
        }
        
        .fade-in-left.visible {
            opacity: 1;
            transform: translateX(0);
        }
        
        .fade-in-right {
            opacity: 0;
            transform: translateX(30px);
            transition: all 0.6s ease;
        }
        
        .fade-in-right.visible {
            opacity: 1;
            transform: translateX(0);
        }
    `;
    
    document.head.appendChild(additionalStyles);
  </script>
</body>
</html>
