<section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
    <h1 class="text-2xl sm:text-3xl font-bold text-center mb-10 sm:mb-12">Contáctanos</h1>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Información de contacto -->
        <div class="bg-white rounded-xl shadow-sm p-6 sm:p-8">
            <h2 class="text-lg sm:text-xl font-semibold mb-6">Información de contacto</h2>

            <div class="space-y-5">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                    </div>
                    <div>
                        <h3 class="font-medium">Bodega — agenda tu visita</h3>
                        <p class="text-gray-600 text-sm">Diagonal 5 B # 71 B - 24, Bogotá, Colombia</p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-phone" aria-hidden="true"></i>
                    </div>
                    <div>
                        <h3 class="font-medium">Teléfono / WhatsApp</h3>
                        <p class="text-gray-600 text-sm">+<?= e(Env::get('WHATSAPP_NUMERO')) ?></p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-envelope" aria-hidden="true"></i>
                    </div>
                    <div>
                        <h3 class="font-medium">Correo</h3>
                        <p class="text-gray-600 text-sm">info@tacoscapital.com</p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-clock" aria-hidden="true"></i>
                    </div>
                    <div>
                        <h3 class="font-medium">Horario de atención</h3>
                        <p class="text-gray-600 text-sm">Lunes a viernes: 9:00 a. m. – 6:00 p. m.</p>
                        <p class="text-gray-600 text-sm">Sábados: 9:00 a. m. – 2:00 p. m.</p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-hand-holding-dollar" aria-hidden="true"></i>
                    </div>
                    <div>
                        <h3 class="font-medium">Formas de pago</h3>
                        <p class="text-gray-600 text-sm">Servicio de abonos (pago por cuotas) y pago con link de pago.</p>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t">
                <h3 class="font-medium mb-3 text-sm">Síguenos en redes sociales</h3>
                <div class="flex gap-4 text-2xl">
                    <a href="https://facebook.com/tacoscapital" target="_blank" rel="noopener" class="text-blue-600 hover:text-blue-800" aria-label="Facebook">
                        <i class="fab fa-facebook-square" aria-hidden="true"></i>
                    </a>
                    <a href="https://instagram.com/tacoscapital" target="_blank" rel="noopener" class="text-pink-600 hover:text-pink-800" aria-label="Instagram">
                        <i class="fab fa-instagram" aria-hidden="true"></i>
                    </a>
                    <a href="<?= e(whatsapp_link()) ?>" target="_blank" rel="noopener" class="text-green-600 hover:text-green-800" aria-label="WhatsApp">
                        <i class="fab fa-whatsapp" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Tarjetas de WhatsApp por tipo de consulta -->
        <div class="bg-white rounded-xl shadow-sm p-6 sm:p-8">
            <h2 class="text-lg sm:text-xl font-semibold mb-2">Contáctanos por WhatsApp</h2>
            <p class="text-gray-600 text-sm mb-6">
                Para una atención más rápida, escríbenos directamente según lo que necesites.
            </p>

            <div class="space-y-4">
                <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                    <h3 class="font-medium text-green-800 mb-1">Consulta sobre productos</h3>
                    <p class="text-green-700 text-sm mb-3">Preguntas sobre algún taco o accesorio.</p>
                    <a href="<?= e(whatsapp_link('Hola, tengo una consulta sobre un producto.')) ?>" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-500 text-white font-semibold px-4 py-2 rounded-lg text-sm transition">
                        <i class="fab fa-whatsapp" aria-hidden="true"></i> Consultar productos
                    </a>
                </div>

                <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                    <h3 class="font-medium text-green-800 mb-1">Servicio técnico</h3>
                    <p class="text-green-700 text-sm mb-3">Reparación, mantenimiento o personalización.</p>
                    <a href="<?= e(whatsapp_link('Hola, necesito servicio técnico para mi taco.')) ?>" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-500 text-white font-semibold px-4 py-2 rounded-lg text-sm transition">
                        <i class="fab fa-whatsapp" aria-hidden="true"></i> Solicitar servicio
                    </a>
                </div>

                <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                    <h3 class="font-medium text-green-800 mb-1">Atención general</h3>
                    <p class="text-green-700 text-sm mb-3">Cualquier otra consulta o información.</p>
                    <a href="<?= e(whatsapp_link()) ?>" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-500 text-white font-semibold px-4 py-2 rounded-lg text-sm transition">
                        <i class="fab fa-whatsapp" aria-hidden="true"></i> Contactar ahora
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Mapa -->
    <div class="mt-8">
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-6 sm:p-8">
                <h2 class="text-lg sm:text-xl font-semibold mb-4">Nuestra ubicación</h2>
                <div class="aspect-video sm:aspect-[21/9] rounded-lg overflow-hidden">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d994.2015918253761!2d-74.1359348303677!3d4.628608136440334!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3f9d003fd34e39%3A0x3de784bb9fedb59e!2sTACOS%20CAPITAL!5e0!3m2!1ses!2sco!4v1743842935182!5m2!1ses!2sco"
                        width="100%" height="100%" style="border:0;" allowfullscreen loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade" title="Ubicación de Tacos Capital en Google Maps"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
