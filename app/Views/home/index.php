<section class="relative h-[70vh] min-h-[420px] flex items-center">
    <div class="absolute inset-0 bg-black/50 z-10"></div>
    <img src="/assets/img/banner_tacos_capital.png" alt="Tacos de billar profesionales"
         class="absolute inset-0 w-full h-full object-cover">
    <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <h1 class="text-3xl sm:text-5xl font-extrabold text-white mb-4 max-w-2xl leading-tight">
            Tacos de billar en Bogotá para todos los niveles
        </h1>
        <p class="text-lg text-gray-200 mb-8 max-w-xl">
            Venta de tacos profesionales y para principiantes, reparación, cambio de virolas y
            suelas, y personalización. Envíos a toda Colombia.
        </p>
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="/productos" class="bg-blue-600 hover:bg-blue-500 text-white font-semibold px-6 py-3 rounded-lg text-center transition">
                Ver catálogo
            </a>
            <a href="<?= e(whatsapp_link()) ?>" target="_blank" rel="noopener"
               class="bg-white hover:bg-gray-100 text-gray-900 font-semibold px-6 py-3 rounded-lg text-center transition">
                Hablar por WhatsApp
            </a>
        </div>
    </div>
</section>

<section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-8 text-center">
        <div class="p-6">
            <i class="fas fa-medal text-3xl text-blue-600 mb-3" aria-hidden="true"></i>
            <h3 class="font-semibold text-lg mb-2">Calidad premium</h3>
            <p class="text-gray-600 text-sm">Los mejores materiales para durabilidad y rendimiento.</p>
        </div>
        <div class="p-6">
            <i class="fas fa-tools text-3xl text-blue-600 mb-3" aria-hidden="true"></i>
            <h3 class="font-semibold text-lg mb-2">Servicio técnico</h3>
            <p class="text-gray-600 text-sm">Reparación y mantenimiento profesional.</p>
        </div>
        <div class="p-6">
            <i class="fas fa-paint-brush text-3xl text-blue-600 mb-3" aria-hidden="true"></i>
            <h3 class="font-semibold text-lg mb-2">Personalización</h3>
            <p class="text-gray-600 text-sm">Tacos a medida según tu estilo de juego.</p>
        </div>
        <div class="p-6">
            <i class="fas fa-hand-holding-dollar text-3xl text-blue-600 mb-3" aria-hidden="true"></i>
            <h3 class="font-semibold text-lg mb-2">Facilidades de pago</h3>
            <p class="text-gray-600 text-sm">Servicio de abonos y pago con link de pago.</p>
        </div>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl sm:text-3xl font-bold">Productos destacados</h2>
            <a href="/productos" class="text-blue-600 hover:text-blue-700 font-medium text-sm">Ver todos →</a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php foreach ($productosDestacados as $producto): ?>
                <?php include __DIR__ . '/../productos/_card.php'; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-10">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold mb-4">Venta de tacos de billar en Bogotá</h2>
            <p class="text-gray-600 mb-4">
                En Tacos Capital vendemos <a href="/productos" class="text-blue-600 hover:underline">tacos de billar profesionales y para principiantes</a>,
                con distintos materiales, punteras y pesos para adaptarse a tu estilo de juego. Hacemos
                envíos a Bogotá y a toda Colombia.
            </p>
            <p class="text-gray-600">
                También manejamos <a href="/productos" class="text-blue-600 hover:underline">virolas, suelas y accesorios</a> de
                repuesto para mantener tu taco en las mejores condiciones.
            </p>
        </div>
        <div>
            <h2 class="text-xl sm:text-2xl font-bold mb-4">Reparación y personalización de tacos</h2>
            <p class="text-gray-600 mb-4">
                Ofrecemos <strong>reparación de tacos de billar en Bogotá</strong>: cambio de virolas,
                cambio de suelas y ajuste de rosca. También personalizamos tacos a medida según el
                estilo de juego de cada jugador.
            </p>
            <p class="text-gray-600">
                ¿Tienes un taco que necesita mantenimiento o quieres uno personalizado?
                <a href="<?= e(whatsapp_link('Hola, quiero información sobre reparación/personalización de un taco.')) ?>"
                   target="_blank" rel="noopener" class="text-blue-600 hover:underline">Escríbenos por WhatsApp</a>
                o visita nuestra <a href="/contacto" class="text-blue-600 hover:underline">página de contacto</a>.
            </p>
        </div>
    </div>
</section>

<section class="pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-blue-50 border border-blue-100 rounded-xl p-6 sm:p-8 flex flex-col sm:flex-row sm:items-center gap-6">
            <div class="flex-1">
                <h2 class="text-xl font-bold mb-2">
                    <i class="fas fa-hand-holding-dollar text-blue-600 mr-2" aria-hidden="true"></i>Formas de pago flexibles
                </h2>
                <p class="text-gray-700">
                    Manejamos <strong>servicio de abonos</strong> (compra tu taco por cuotas) y
                    aceptamos <strong>pago con link de pago</strong>. Escríbenos por WhatsApp y te
                    contamos cómo funciona para el producto que te interesa.
                </p>
            </div>
            <a href="<?= e(whatsapp_link('Hola, quiero información sobre formas de pago (abonos / link de pago).')) ?>"
               target="_blank" rel="noopener"
               class="bg-green-600 hover:bg-green-500 text-white font-semibold px-6 py-3 rounded-lg text-center transition whitespace-nowrap">
                <i class="fab fa-whatsapp" aria-hidden="true"></i> Consultar formas de pago
            </a>
        </div>
    </div>
</section>
