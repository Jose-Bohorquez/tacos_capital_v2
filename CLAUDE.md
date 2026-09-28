# Tacos Capital

E-commerce/catálogo de tacos de billar (Bogotá). Sitio real en producción:
`https://tacoscapital.online/` (el dominio anterior, `tacoscapital.com`, venció y no se
renovó — este es el reemplazo real, migrado el 2026-09-27). Panel admin en `/admin/login`.
Espejo local de trabajo en esta carpeta — el servidor sigue siendo la fuente de verdad
hasta que este repo git tenga historial propio.

## Arquitectura — dónde vive cada cosa (importante, no es obvio)

Este proyecto usa la práctica correcta de sacar todo lo sensible **fuera** del document root:

```
domains/tacoscapital.online/          ← carpeta del dominio en Hostinger (NO toda expuesta)
├── app/              ← código PHP real (Router/Controller/Model) — NO accesible por HTTP
├── database/         ← schema.sql, migraciones — NO accesible por HTTP
├── private_tc/docs/  ← documentación técnica — NO accesible por HTTP
├── storage/logs/     ← logs — NO accesible por HTTP
├── .env              ← credenciales BD — NO accesible por HTTP
└── public_html/       ← ÚNICO document root real, esto SÍ ve internet
    ├── index.php      (front controller, único punto de entrada)
    ├── assets/
    └── uploads/productos/   (imágenes de producto)
```

**Verificado con curl real** (no de memoria): `https://tacoscapital.online/../app/Core/Database.php`
y `https://tacoscapital.online/.env` devuelven 403/404 — Hostinger solo sirve lo que está
dentro de `public_html/`, todo lo demás existe en disco pero es inalcanzable por URL. Esto
es intencional y correcto (si `.env` estuviera dentro de `public_html`, la contraseña de la
BD sería descargable por cualquiera). **No mover `app/`, `.env`, `storage/` o `database/`
dentro de `public_html/` — sería una regresión de seguridad real, no una limpieza.**

## Stack

- PHP 8.x plano, MVC propio (`app/Core/Router.php`, `Controller.php`, `Model.php`,
  `Database.php` con PDO) — sin framework, sin composer.
- MySQL/MariaDB (Hostinger). BD real: `u682531786_tc` (migrada 2026-09-27 desde la BD vieja
  `u682531786_bd_tc_02` de `tacoscapital.com`).
- Tailwind CSS **compilado estáticamente y purgado** — no hay Node/npm/tailwindcss en este
  hosting. `public_html/assets/css/app.css` es el build final; una clase Tailwind que no
  estaba ya en uso en otra vista **no tiene CSS generado** (se descubrió con `pl-10`,
  `absolute`, `min-h-[44px]` al agregar el buscador de productos — no renderizaban nada).
  Para UI nueva: o reusar clases ya confirmadas en otra vista, o escribir CSS plano en un
  `<style>` inline (el CSP sí permite `style-src 'unsafe-inline'`).
- **CSP activo** (`Content-Security-Policy` real en producción) que solo permite
  `script-src 'self' https://cdnjs.cloudflare.com` — bloquea scripts inline y cualquier otro
  host (ej. jsdelivr.net). Cualquier librería JS nueva debe cargarse desde cdnjs (verificar
  la ruta exacta con `api.cdnjs.com/libraries/<nombre>` antes de asumir la URL — DataTables
  tiene el motor en el paquete `datatables.net`, NO en `datatables.net-dt` que es solo
  estilos, error real cometido una vez).
- DataTables (jQuery) en `admin/productos` — único lugar del admin que lo usa, cargado desde
  cdnjs, JS de inicialización en `public_html/assets/js/admin-productos.js` (no inline, por
  el CSP).
- SweetAlert2 para confirmaciones (ya estaba antes de este trabajo).

## Reglas

- No mover código/config fuera de su separación actual (ver Arquitectura arriba).
- No asumir que una clase Tailwind "debería funcionar" — verificar que ya se use en alguna
  vista existente antes de confiar en ella; si no, CSS plano.
- Cualquier CDN externo nuevo: confirmar que esté permitido por el CSP antes de usarlo.
- `.env` nunca se transcribe en el chat ni en commits — solo existe en el servidor y en la
  copia local (gitignored).
- Antes de desplegar cambios: `php -l` en el servidor tras subir, y verificar en navegador
  real (esta sesión usa Chrome DevTools MCP, no Puppeteer, para este proyecto).

## Deuda técnica pendiente (real, no resuelta todavía)

- **323 fotos de producto sin optimizar** en `public_html/uploads/productos/` — 379MB
  totales, promedio 1.2MB por foto (algunas de hasta 3.5MB), subidas directo de
  cámara/celular sin comprimir para web. Afecta tiempo de carga real del catálogo,
  especialmente en móvil. Pendiente: comprimir a WebP/JPEG optimizado.
- `public_html_legacy_20260715/` sigue en el servidor (versión anterior a la migración a
  MVC) — no se ha confirmado si se puede eliminar.

## graphify

Este proyecto tiene un grafo de conocimiento en `graphify-out/` (solo código — 728 archivos
no-código como fotos/docs se excluyeron con `--code-only`, no hay API key configurada para
extracción semántica de esos).

Reglas:
- Para preguntas del código, correr primero `graphify query "<pregunta>"` cuando exista
  `graphify-out/graph.json`. `graphify path "<A>" "<B>"` para relaciones, `graphify explain
  "<concepto>"` para conceptos puntuales.
- Leer `graphify-out/GRAPH_REPORT.md` solo para revisión de arquitectura amplia.
- Después de modificar código, correr `graphify update .` (solo AST, sin costo de API).

Nodos más conectados (God Nodes): `Product`, `Session`, `ProductImage`,
`AdminProductController`, `AuthMiddleware`.
