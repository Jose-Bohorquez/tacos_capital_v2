# Tacos Capital — Flujo técnico (v2, MVC)

Última actualización: 2026-07-28. Complementa `ARQUITECTURA.md`.

## 1. Flujo de catálogo (visitante)

```
/ (HomeController) ──▶ Product::destacados(8) — solo los marcados desde el admin
                        (fallback a Product::all() más recientes si ninguno está marcado)
/productos (ProductController::index) ──▶ Product::all($busqueda) — con buscador por nombre
/producto/{slug} (ProductController::show) ──▶ Product::findBySlug($slug)
                        galería con carrusel real (JS en assets/js/galeria.js, no inline —
                        ver ARQUITECTURA.md § CSP y JavaScript)
                                                        │
                                    botón WhatsApp (whatsapp_link()) ──▶ wa.me/573188763377
/contacto (ContactController) ──▶ vista estática con info de contacto, horario, redes sociales
                        reales y mapa de Google embebido (iframe, permitido por CSP frame-src
                        'self' https://www.google.com)
```

Sigue sin haber carrito/checkout — mismo modelo de negocio que el sitio viejo (catálogo → WhatsApp →
venta manual), pero ahora con datos reales en MySQL en vez de carpetas.

## 2. Redirects de URLs viejas (crítico para no perder SEO)

```
/productos/detalle.php?id=<slug-viejo> (ProductController::redirectLegacy)
        ──▶ LegacyRedirect::resolver($slugViejo) consulta legacy_slug_map
        ──▶ 301 a /producto/<slug-nuevo>
```

Este mapeo se generó una sola vez en `database/migrate_legacy.php` al migrar los 68 productos.
Si en el futuro se crean productos nuevos manualmente (no migrados), no tendrán entrada en
`legacy_slug_map` — no la necesitan, nunca existieron con una URL vieja.

## 3. Flujo de imágenes (subida desde el admin)

```
admin/productos/nuevo o /editar (form multipart) ──▶ AdminProductController::store()/update()
                                                                │
                                        guardarImagenes() ──▶ ProductImage::agregarDesdeUpload()
                                                                │
                        validar(): extensión whitelist + MIME real (finfo) + getimagesize()
                        real → si falla, se descarta EN SILENCIO para el usuario pero se registra
                        en storage/logs/app.log ("Upload rechazado producto N: <motivo>")
                                                                │
                        procesarImagen(): GD, resize proporcional, exporta WebP (calidad 82),
                        dos tamaños: principal (max 1600px) y _thumb (max 500px)
                                                                │
                        guarda en public_html/uploads/productos/<id>/imagen-<orden>-<random>.webp
                        INSERT en product_images (url, url_thumb, orden, es_principal)
```

Probado en vivo (2026-07-15): subir un archivo `evil.php` renombrado con `Content-Type: image/jpeg`
→ rechazado por extensión antes de llegar a GD. El producto se crea igual (sin esa imagen), no hay
manera de bloquear la creación del producto por un archivo rechazado — comportamiento esperado, no
un bug.

## 3bis. Gestión de imágenes existentes (agregado 2026-07-16)

A pedido de Jose, `/admin/productos/{id}/editar` ahora permite, por cada imagen:

```
"Hacer principal"  ──▶ POST .../imagenes/{imagenId}/principal
                        ──▶ AdminProductController::setImagenPrincipal()
                        ──▶ ProductImage::hacerPrincipal() (quita es_principal=1 de todas las
                            imágenes del producto, lo pone solo en la elegida)

"Convertir a WebP" ──▶ POST .../imagenes/{imagenId}/optimizar (solo visible si la imagen NO es
                        ya .webp — típicamente imágenes migradas del sitio viejo, que se copiaron
                        tal cual sin pasar por el pipeline GD, ver § 5)
                        ──▶ AdminProductController::optimizarImagen()
                        ──▶ ProductImage::optimizarAWebp(): reprocesa el archivo original con el
                            MISMO pipeline GD de agregarDesdeUpload() (resize + WebP calidad 82,
                            2 tamaños), actualiza url/url_thumb en BD, borra el/los archivo(s)
                            original(es)

"✕ Eliminar"       ──▶ ya documentado arriba (§ 6, bug 4)
```

Probado en vivo con un producto de prueba dedicado (creado y borrado en la misma sesión, para no
repetir el incidente del § 6): las 3 acciones funcionan — cambio de principal confirmado en BD,
conversión JPG→WebP confirmada (archivo original borrado, solo queda el `.webp` nuevo), eliminación
de imagen individual confirmada.

## 4. Login de administrador

```
GET  /admin/login  ──▶ AdminAuthController::showLogin() (layout admin-guest, sin sidebar)
POST /admin/login  ──▶ CsrfMiddleware::verify() + Auth::attempt($usuario, $password)
                              │
                    Admin::findByUsername() + password_verify() contra el hash real en BD
                              │
                    éxito: Session::regenerate() + admin_id/admin_ip/admin_last_activity en sesión
                    fallo: usleep(300ms) + mensaje genérico (no revela si el usuario existe)
```

`Auth::check()` (llamado por `AuthMiddleware::handle()` en cada ruta `/admin/*`) valida sesión activa,
compara `admin_ip` contra la IP actual, y expira a los 30 min de inactividad — mismo criterio que el
`auth_check.php` del sitio viejo, pero ahora sin la contraseña base64 trivial detrás.

Credenciales reales creadas el 2026-07-15 con `database/create_admin.php` — **si se pierde la
contraseña, correr de nuevo ese script (hace upsert por username, no hay "recuperar contraseña" por
email todavía)**.

## 4bis. Productos destacados (home)

```
admin/productos (botón ⭐) ──▶ POST /admin/productos/{id}/destacado
                                        ──▶ AdminProductController::toggleDestacado()
                                        ──▶ Product::toggleDestacado() (UPDATE ... destacado = NOT destacado)
```

También se puede marcar/desmarcar desde el checkbox del formulario crear/editar. `HomeController`
usa `Product::destacados(8)` — si la lista viene vacía (nada marcado todavía), cae a los 8 más
recientes para que el home nunca se vea vacío.

## 5. Migración de contenido (ya ejecutada, no repetir)

`database/migrate_legacy.php ~/domains/tacoscapital.com/public_html_legacy_20260715/storage/productos`
— corrido el 2026-07-15, migró los 68 productos:
- Limpia automáticamente prefijos tipo "1, "/"2," del nombre (hallazgo de la auditoría SEO).
- Genera slug único nuevo por nombre limpio (no reutiliza el slug-carpeta viejo, salvo coincidencia).
- Copia las imágenes tal cual (sin reprocesar a WebP) a `uploads/productos/<id-nuevo>/legacy-N-<nombre-original>`
  — si se quiere que pasen por el pipeline WebP, hay que volver a subirlas desde el admin (edit →
  reemplazar imagen). No se hizo automáticamente para no arriesgar la calidad en una migración masiva
  de una sola pasada.
- Registra el mapeo slug viejo → nuevo en `legacy_slug_map` (ver punto 2).

## 6. Bugs reales encontrados y corregidos durante el despliegue (2026-07-15)

1. **Parámetro SQL duplicado**: `migrate_legacy.php` usaba `:url` dos veces en el mismo INSERT
   (`url` y `url_thumb`) — con `PDO::ATTR_EMULATE_PREPARES => false` (prepared statements nativos de
   MySQL) esto lanza `PDOException: Invalid parameter number`, a diferencia de la emulación de PDO
   que sí permite reusar nombres. Corregido usando placeholders distintos (`:url`, `:urlthumb`).
2. **Mismatch autoloader / nombre de archivo**: los tres controllers de `Controllers/Admin/` se
   crearon como `AuthController.php`, `DashboardController.php`, `ProductController.php`, pero las
   clases dentro son `AdminAuthController`, `AdminDashboardController`, `AdminProductController`. El
   autoloader de `public_html/index.php` busca el archivo por el nombre exacto de la clase → 500 en
   `/admin/login` ("Class AdminAuthController not found"). Corregido renombrando los 3 archivos para
   que coincidan con su clase. **Si se agregan controllers nuevos, el nombre de archivo SIEMPRE debe
   ser idéntico al nombre de la clase.**

Ambos se detectaron y corrigieron en la misma sesión de QA post-swap, antes de considerar el
despliegue terminado.

3. **`ProductImage.php` apuntaba a una carpeta `public/` que ya no existe** (encontrado 2026-07-16,
   varias horas después del swap): `carpetaProducto()` y `eliminar()` usaban
   `__DIR__ . '/../../public/...'`, ruta correcta **solo mientras el proyecto vivía en
   `app_new/public/`**. Tras el swap el document root se renombró a `public_html/`, pero estas dos
   rutas nunca se actualizaron. Efecto real: **cualquier subida o eliminación de imagen posterior al
   swap fallaba silenciosamente a nivel de archivo** (la subida escribía en una ruta que no existe
   ni es servida por el navegador; el borrado no encontraba el archivo real y solo limpiaba la fila
   de la BD dejando el archivo huérfano en disco). Se detectó porque el admin de edición de producto
   (`/admin/productos/{id}/editar`) no mostraba las imágenes — ver también bug #4. Corregido
   cambiando ambas rutas a `__DIR__ . '/../../public_html/...'`. **Lección**: cualquier ruta con
   `__DIR__` que cruce la frontera `app/ ↔ document root` es frágil ante un rename del document
   root — conviene centralizarla en una sola constante/config en vez de repetirla en cada método.
4. **`Product::findById()` no cargaba imágenes** (a diferencia de `findBySlug()`/`all()`/`destacados()`,
   que sí llaman a `imagenesDe()`). Como `AdminProductController::edit()` usa `findById()`, la vista
   de edición nunca mostraba las fotos existentes ni daba forma de borrarlas — reportado por Jose el
   2026-07-16 viendo `/admin/productos/68/editar`. Corregido agregando la carga de imágenes también
   en `findById()`. De paso se agregó la función que faltaba: botón de eliminar por imagen individual
   (`POST /admin/productos/{id}/imagenes/{imagenId}/eliminar` →
   `AdminProductController::destroyImage()` → `ProductImage::eliminar()`, que ya existía en el
   modelo pero no tenía ruta ni UI conectada).

⚠️ **Nota de QA para quien retome este proyecto**: al verificar el fix del bug #3 se perdieron por
error 2 de las 3 imágenes reales de "virola traslucida" (id 68) durante las pruebas en vivo —
se restauraron desde `public_html_legacy_20260715/storage/productos/virola_traslucida/images/`
(el backup completo del sitio viejo sigue intacto ahí). Sirve como recordatorio: **probar flujos de
eliminación en vivo contra datos reales es riesgoso** — para pruebas de creación/eliminación futuras,
crear un producto de prueba dedicado en vez de operar sobre uno real, o restaurar de inmediato si algo
sale mal (como se hizo aquí, gracias a que el backup legacy nunca se borra).

## 7. Auditoría UX/UI/SEO (2026-07-28) — hallazgos y fixes

Sesión de auditoría a pedido de Jose, con verificación en vivo (`curl`) de cada cambio, no solo
lectura de código. Todo con backup previo en `~/backups/` antes de tocar cada archivo.

**Accesibilidad**:
- `productos/index.php`: buscador y `<select>` de categoría sin `<label>` → agregadas labels
  `sr-only` (`for="buscar-producto"` / `for="filtro-categoria"`).
- 49 iconos `fas`/`fab` en las 13 vistas (públicas + admin) sin `aria-hidden="true"` → agregado
  mecánicamente (script que solo agrega el atributo si no existe ya).
- Botones prev/siguiente de la galería en `/producto/{slug}` (36×36px, `w-9 h-9`) subidos a
  44×44px (`w-11 h-11`) — mínimo recomendado para objetivos táctiles.
- Contraste insuficiente: botón "Marcar" en `/admin/productos` (`text-gray-400` sobre blanco,
  ~2.9:1) → `text-gray-500 hover:text-gray-700`. Link "Administración" del footer público
  (`text-gray-600` sobre `bg-gray-900`) → `text-gray-500 hover:text-white` (se mantuvo discreto
  a propósito, Jose no quería que fuera prominente).

**Rendimiento/UX**:
- `/productos` cargaba los 68 productos en una sola página, sin paginación. Agregada paginación
  real (ver ARQUITECTURA.md § esquema de BD para `Product::all()`/`countAll()`): 24 productos por
  página, controles prev/actual/siguiente que preservan `buscar`/`categoria` en el querystring,
  `?page=N` clamp a `[1, totalPáginas]` (tolera valores fuera de rango o inválidos sin romper),
  canonical dinámico agrega `&page=N` solo si `page > 1`.

**SEO técnico** (el hallazgo más importante de esta ronda, no visible navegando normal):
- **`app/Core/Router.php::dispatch()` devolvía 404 en TODAS las rutas ante peticiones HEAD**
  (`curl -I`/`curl -X HEAD` → 404; `curl` GET normal → 200 en las mismas rutas). Causa: el router
  solo compara el método de la petición contra rutas registradas como `GET`/`POST` — `HEAD` nunca
  hacía match. Esto importa porque muchas herramientas de SEO/backlinks (Ahrefs, Screaming Frog,
  monitores de uptime) usan HEAD por defecto para verificar si un enlace está roto — un backlink
  real hacia tacoscapital.com podía reportarse como "roto" sin estarlo. Fix: `dispatch()` ahora
  busca la ruta usando `GET` cuando el método real es `HEAD` (estándar HTTP: HEAD = GET sin
  cuerpo). Verificado con `curl -I` en las 5 rutas públicas + admin → 200, sin romper ningún
  GET/POST existente ni el 404 real de rutas inexistentes.
- **`logo.jpg` (referenciado en el JSON-LD `Store` de todas las páginas) daba 404** — se había
  generado como placeholder el 2026-07-14 pero se perdió en la reconstrucción MVC del 2026-07-15
  (no estaba en la lista de assets migrados a `public_html/assets/img/`). Regenerado igual que la
  vez anterior: recorte cuadrado 512×512 del banner existente vía PHP GD directo en el servidor
  (sigue siendo temporal — falta que el cliente suba un logo de marca real).
- Meta description del home (169 caracteres, arriba del límite práctico de Google ~155-160 antes
  de truncar el snippet) → reescrita a 144 caracteres, quitando la redundancia
  "Bogotá, Colombia" + "todo el país" (se dejó solo "Bogotá" + "toda Colombia").
- Sin `apple-touch-icon` (ni archivo ni `<link>` en el `<head>`) → generado 180×180 PNG (mismo
  recorte del banner) y agregado en `layouts/main.php`. No es factor de ranking de Google pero sí
  afecta cómo se ve el ícono al agregar el sitio a la pantalla de inicio en iOS.
- Se revalidó que el bloqueo de Googlebot (corregido en la auditoría SEO original) sigue
  funcionando: `curl` con user-agent de Googlebot → 200.

**Limitación técnica que sigue vigente**: no hay `tailwind.config.js`/`src.css` disponibles (se
perdieron entre sesiones, ni están en este servidor ni en la máquina de trabajo actual) y no hay
Node en el servidor — no se puede recompilar Tailwind de forma normal. Los fixes de arriba que
necesitaron clases nuevas (`.sr-only`, `.w-11`/`.h-11`) se resolvieron agregándolas manualmente al
`app.css` ya compilado (reglas idénticas a las que generaría Tailwind) — funciona pero no escala
bien si se necesitan muchas clases nuevas a futuro. Reconstruir el pipeline completo queda
pendiente si Jose lo pide.

**Pendiente de SEO, no técnico** (sigue igual que la auditoría original de 2026-07-14): Google
Business Profile, backlinks reales, limpieza manual de nombres/descripciones de los 68 productos
(typos, formato de inventario) desde el admin.
