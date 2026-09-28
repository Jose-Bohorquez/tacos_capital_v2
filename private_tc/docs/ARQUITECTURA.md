# Tacos Capital — Arquitectura técnica (v2, MVC)

Última actualización: 2026-07-28. Reemplaza la versión anterior (v1, PHP plano basado en
archivos) — esa versión quedó retirada en `~/domains/tacoscapital.com/public_html_legacy_20260715/`
(solo como backup, no accesible por web). El detalle histórico de por qué se reconstruyó vive en
la memoria de Claude, ver [[project-tacoscapital-seo]].

## Acceso

- SSH: alias `htg`/`bd-tech-hostinger`, mismo servidor que Nido Pastel.
- Sitio: `https://tacoscapital.com/`.
- Admin: `https://tacoscapital.com/admin/login` (usuario/contraseña real en BD, ya no hardcodeado).
- Código: `~/domains/tacoscapital.com/`:
  ```
  public_html/     # document root — SOLO esto es accesible por web (front controller + assets)
  app/             # Controllers/Models/Views/Core/Middleware — FUERA del document root
  database/        # schema.sql, migrate_legacy.php, create_admin.php
  storage/logs/    # app.log, php_errors.log — display_errors=Off en producción
  .env             # credenciales reales, chmod 600, fuera de public_html
  public_html_legacy_20260715/   # backup del sitio viejo (PHP plano sin BD), no accesible por web
  private_tc/docs/ # esta documentación
  ```

## Stack

- PHP plano con **MVC propio** (sin Composer/framework): `Router → Controller → Model → View`,
  autoload por convención (nombre de archivo = nombre de clase, ver `public_html/index.php`).
- Base de datos MySQL real: `u682531786_bd_tc_02` (usuario `u682531786_u5u_bd_tc_02`, credenciales en
  `.env`). Reemplaza por completo el almacenamiento en archivos del sitio anterior.
- Tailwind **compilado localmente** (no CDN) — `public_html/assets/css/app.css`, generado con
  `npx tailwindcss` a partir de `src.css` + `tailwind.config.js` (viven en el repo local de
  desarrollo, no en el servidor — si se necesita recompilar, hacerlo en local y subir el CSS).

## Esquema de base de datos (`database/schema.sql`)

- `admins` (id, username, password_hash, created_at) — `password_hash()`/`password_verify()` reales.
- `categories` (id, nombre, slug, orden) — agregada 2026-07-16. 9 categorías reales, inferidas de
  los 68 productos existentes y asignadas por patrón de nombre (ver `Category` model):
  Tacos de Billar, Casquillos, Virolas, Tizas y Porta-tizas, Bolas de Billar, Estuches, Guantes,
  Herramientas y Accesorios, Servicios. Se asignan/editan desde el select de categoría en el
  formulario admin de producto (`category_id`, opcional — "Sin categoría" es válido).
- `products` (id, nombre, slug, descripcion, precio, **destacado** (TINYINT, agregado 2026-07-15),
  **category_id** (FK nullable → categories, ON DELETE SET NULL, agregada 2026-07-16),
  created_at, updated_at). `destacado` controla la sección "Productos destacados" del home
  (`Product::destacados()`), con toggle rápido desde `/admin/productos` (botón de estrella,
  `AdminProductController::toggleDestacado`) y checkbox en el formulario crear/editar. Si ningún
  producto tiene `destacado=1`, el home cae de vuelta a mostrar los más recientes (nunca queda vacío).
  `category_id` filtra el catálogo (`/productos?categoria=<slug>`), combinable con el buscador
  (`?buscar=<texto>`) — `Product::all($search, $categoryId, $limite, $offset)` acepta ambos
  parámetros de filtro más paginación opcional (agregada 2026-07-28, ver FLUJO-TECNICO.md § 7).
  `$limite`/`$offset` son opcionales (default 0 = sin límite, comportamiento previo intacto) —
  `HomeController`, `AdminProductController`, `AdminDashboardController` y `SitemapController`
  siguen llamando `all()` sin esos argumentos porque necesitan el listado completo, no paginado.
  `Product::countAll($search, $categoryId)` (nuevo) devuelve el total sin paginar, usado por
  `/productos` para calcular el número de páginas (24 productos/página).
- `product_images` (id, product_id → products ON DELETE CASCADE, url, url_thumb, orden, es_principal).
- `legacy_slug_map` (slug_viejo, slug_nuevo) — mapeo usado por
  `ProductController::redirectLegacy()` para redirigir 301 las URLs viejas
  (`/productos/detalle.php?id=<slug-de-carpeta>`) hacia `/producto/<slug-nuevo>`, para no perder el
  rastreo/indexación que Google ya validó en Search Console antes de la reconstrucción.

## Estructura de `app/`

```
Core/       Router (⚠️ solo registra rutas GET/POST; dispatch() trata HEAD como GET desde
            2026-07-28 — ver FLUJO-TECNICO.md § 7, cualquier método nuevo que se agregue debe
            revisar ese mapeo), Controller, Model, Database (PDO singleton, prepared statements
            siempre), View (render con layout + helper e() de escape), Session, Auth, Request,
            Env, helpers.php
Middleware/ AuthMiddleware (protege /admin/*), CsrfMiddleware (valida _csrf en todo POST)
Models/     Product, ProductImage (pipeline GD: WebP en 2 tamaños, nombre de archivo generado por
            el sistema — nunca el original), Admin, LegacyRedirect, Category
Controllers/            HomeController, ProductController, ContactController, SitemapController
Controllers/Admin/      AdminAuthController, AdminDashboardController, AdminProductController
            (⚠️ el nombre de archivo DEBE coincidir con el nombre de la clase — el autoloader de
            public_html/index.php busca `Controllers/Admin/{NombreClase}.php` literal; un mismatch
            aquí causó un bug real al desplegar, ver Flujo técnico § Bugs encontrados en el swap)
Views/      layouts/{main,admin,admin-guest}.php, home/, productos/ (index, show, _card parcial),
            contacto/, admin/ (login, dashboard, productos/index, productos/form), errors/404.php
```

## Admin — UX/UI (ajustado 2026-07-16)

- `layouts/admin.php`: sidebar fija solo en desktop (`md:flex`); en móvil hay una barra superior
  con botón hamburguesa (`#admin-menu-toggle`) que despliega un menú (`#admin-mobile-menu`) con
  Dashboard/Productos/Cerrar sesión — antes el sidebar simplemente desaparecía en móvil sin
  reemplazo, dejando el admin inavegable desde el celular. JS en `assets/js/admin.js` (externo,
  ver § CSP más abajo).
- `admin/productos/index.php`: **dos layouts según viewport**, no solo una tabla con scroll
  horizontal — tarjetas apiladas en `sm:hidden` (móvil) y la tabla completa en `hidden sm:block`
  (tablet/desktop). Mismo patrón a replicar si se agregan más listados admin en el futuro.
- `admin/dashboard.php`: 3 tarjetas de métricas (productos totales, destacados, **productos sin
  imágenes** — señal útil para saber qué falta cargar) + accesos rápidos. Datos vienen de
  `AdminDashboardController::index()`.

## Seguridad — qué cambió respecto al sitio viejo

- Login real contra `admins` en MySQL, sin credenciales en código.
- CSRF (`csrf_field()`/`csrf_verify()`) en todo formulario de mutación.
- Subida de imágenes con whitelist real de extensión (`jpg/jpeg/png/webp/gif`) + verificación de
  tipo MIME real (`finfo`) + `getimagesize()`, nombre de archivo siempre generado por el sistema.
  Probado en vivo subiendo un `.php` disfrazado de imagen: **rechazado correctamente**, queda
  registrado en `storage/logs/app.log`.
- `public_html/uploads/.htaccess` desactiva ejecución de PHP en esa carpeta como segunda capa de
  defensa.
- `display_errors=Off` en producción; errores van a `storage/logs/php_errors.log`.
- `admin.tar` (el backup viejo que quedaba público) ya no existe en `public_html` — quedó dentro de
  `public_html_legacy_20260715/`, no accesible por web.

## SEO — qué se preservó y qué se confirmó real

- Mismo bloqueo de Googlebot corregido, portado al `.htaccess` nuevo (nunca bloquear
  googlebot/bingbot/etc. aunque coincidan con el patrón genérico de "bot").
- `robots.txt` y `sitemap.xml` (ahora generado dinámicamente por `SitemapController` desde la tabla
  `products`, no un archivo estático que se desactualiza).
- Canonical/OG portados al layout `main.php`.
- 301 automático de cada URL vieja de producto hacia la nueva vía `legacy_slug_map`.
- **JSON-LD actualizado de `OnlineStore` a `Store` con dirección y horario reales** (2026-07-16):
  se recuperó del sitio viejo el iframe de Google Maps con el pin real de negocio "TACOS CAPITAL",
  lo que **confirmó** que la dirección "Diagonal 5 B # 71 B - 24, Bogotá" no era un dato inventado
  (a diferencia de la duda que había quedado abierta en la auditoría del 2026-07-14) — es la
  bodega real, visitable con cita previa ("agenda tu visita"). El `layouts/main.php` ahora incluye
  `address` + `openingHoursSpecification` reales en el JSON-LD.
- Redes sociales reales recuperadas del sitio viejo: `facebook.com/tacoscapital`,
  `instagram.com/tacoscapital` (antes eran placeholders genéricos `facebook.com/`, `instagram.com/`
  sin handle) — en footer y página de contacto.

## ⚠️ CSP y JavaScript — lección aprendida (2026-07-15/16)

El `.htaccess` define `Content-Security-Policy: script-src 'self' https://cdnjs.cloudflare.com`
— **sin `'unsafe-inline'`**. Cualquier `<script>...</script>` inline en una vista queda **bloqueado
silenciosamente por el navegador** (no da error PHP, simplemente no ejecuta — así se manifestó
como "el carrusel de fotos no funciona" cuando en realidad el JS nunca corría). Regla para
vistas nuevas: **todo JS va en un archivo bajo `public_html/assets/js/` y se referencia con
`<script src="...">`**, nunca inline. Archivos actuales: `menu.js` (toggle de menú móvil),
`galeria.js` (carrusel de fotos de producto, incluido globalmente en el layout — es un no-op si la
página no tiene `#galeria`). Además, **cualquier vista que use clases de Tailwind nuevas requiere
recompilar `app.css` en local** (`npx tailwindcss -i ./src.css -o ./public/assets/css/app.css
--minify`, ver `package.json`/`tailwind.config.js` del repo local de desarrollo) **antes** de subirla
— si se sube la vista sin recompilar, esas clases faltan en el CSS y la página se ve rota/no
responsiva aunque el HTML esté bien.

**Corolario descubierto 2026-07-16**: el mismo bloqueo de CSP aplica a **atributos de evento inline**
(`onsubmit="..."`, `onclick="..."`), no solo a `<script>` — un `onsubmit="return confirm(...)"` en
un formulario **tampoco se ejecuta** bajo esta CSP. Esto pasó desapercibido en los `confirm()` de
"¿eliminar producto?"/"¿eliminar imagen?" del admin: probablemente nunca se mostraban, el formulario
se enviaba directo. Reemplazados por SweetAlert2 (cargado desde cdnjs, ya permitido en `script-src`)
+ listeners agregados en JS externo (`assets/js/admin-confirm.js`, vía clases `.js-confirm-delete-*`
+ `preventDefault()` + `form.submit()` tras confirmar). **Regla ampliada**: nunca usar atributos
`onclick`/`onsubmit`/`onXxx` en el HTML de ninguna vista — ni siquiera para un `confirm()` simple —
siempre `addEventListener` desde un archivo en `assets/js/`. Se repitió casi el mismo error al
implementar el filtro de categorías del catálogo (`onchange="this.form.submit()"` en el `<select>`)
— corregido antes de subir, con `assets/js/catalogo.js` + `addEventListener('change', ...)`.

Ver `FLUJO-TECNICO.md` para el detalle de cada flujo y los bugs reales que aparecieron al desplegar.
