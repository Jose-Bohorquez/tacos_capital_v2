<?php

final class ProductController extends Controller
{
    public function index(): void
    {
        $productModel = new Product();
        $categoryModel = new Category();

        $busqueda = Request::query('buscar');
        $categoriaSlug = Request::query('categoria');
        $categoriaActual = $categoriaSlug !== '' ? $categoryModel->findBySlug($categoriaSlug) : null;

        $porPagina = 24;
        $totalProductos = $productModel->countAll($busqueda, $categoriaActual['id'] ?? null);
        $totalPaginas = max(1, (int) ceil($totalProductos / $porPagina));
        $pagina = max(1, min($totalPaginas, (int) Request::query('page', '1')));

        $productos = $productModel->all(
            $busqueda,
            $categoriaActual['id'] ?? null,
            $porPagina,
            ($pagina - 1) * $porPagina
        );

        $titulo = $categoriaActual
            ? $categoriaActual['nombre'] . ' — Tacos Capital'
            : 'Catálogo de Tacos de Billar en Bogotá';

        $canonicalBase = Env::get('APP_URL') . '/productos' . ($categoriaActual ? '?categoria=' . $categoriaActual['slug'] : '');
        $canonical = $canonicalBase . ($pagina > 1 ? ($categoriaActual ? '&' : '?') . 'page=' . $pagina : '');

        $this->render('productos/index', [
            'titulo' => $titulo,
            'descripcion' => 'Tacos de billar profesionales y para principiantes, virolas, suelas y accesorios. Compra online con envíos a toda Colombia desde Bogotá.',
            'canonical' => $canonical,
            'productos' => $productos,
            'totalProductos' => $totalProductos,
            'busqueda' => $busqueda,
            'categorias' => $categoryModel->all(),
            'categoriaActual' => $categoriaActual,
            'pagina' => $pagina,
            'totalPaginas' => $totalPaginas,
        ]);
    }

    public function show(string $slug): void
    {
        $productModel = new Product();
        $producto = $productModel->findBySlug($slug);

        if (!$producto) {
            $this->notFound();
        }

        $tituloProducto = mb_convert_case($producto['nombre'], MB_CASE_TITLE, 'UTF-8');
        $descripcionProducto = $producto['descripcion'] !== ''
            ? mb_substr($producto['descripcion'], 0, 160)
            : "{$tituloProducto} — disponible en Tacos Capital, Bogotá. Consulta precio y disponibilidad por WhatsApp.";

        $this->render('productos/show', [
            'titulo' => $tituloProducto,
            'descripcion' => $descripcionProducto,
            'canonical' => Env::get('APP_URL') . '/producto/' . $producto['slug'],
            'ogImage' => !empty($producto['imagenes'])
                ? Env::get('APP_URL') . '/' . $producto['imagenes'][0]['url']
                : null,
            'producto' => $producto,
            'ocultarWhatsappFlotante' => true,
        ]);
    }

    /**
     * Redirige las URLs viejas (?id=<slug-de-carpeta>) hacia /producto/<slug>
     * usando el mapeo generado por database/migrate_legacy.php,
     * para no perder el rastreo/indexación que Google ya validó.
     */
    public function redirectLegacy(): void
    {
        $idViejo = Request::query('id');
        if ($idViejo === '') {
            $this->notFound();
        }

        $productModel = new Product();
        $mapeo = LegacyRedirect::resolver($idViejo);

        if ($mapeo === null) {
            $this->notFound();
        }

        header('Location: /producto/' . $mapeo, true, 301);
        exit;
    }
}
