<?php

final class AdminProductController extends Controller
{
    public function index(): void
    {
        AuthMiddleware::handle();

        $productModel = new Product();
        $this->render('admin/productos/index', [
            'titulo' => 'Productos',
            'productos' => $productModel->all(),
        ], layout: 'layouts/admin');
    }

    public function create(): void
    {
        AuthMiddleware::handle();
        $this->render('admin/productos/form', [
            'titulo' => 'Agregar producto',
            'producto' => null,
            'categorias' => (new Category())->all(),
        ], layout: 'layouts/admin');
    }

    public function store(): void
    {
        AuthMiddleware::handle();
        CsrfMiddleware::verify();

        $nombre = Request::input('nombre');
        $descripcion = Request::input('descripcion');
        $precioRaw = Request::input('precio');
        $precio = $precioRaw !== '' ? (float) $precioRaw : null;
        $destacado = Request::input('destacado') === '1';
        $categoryIdRaw = Request::input('category_id');
        $categoryId = $categoryIdRaw !== '' ? (int) $categoryIdRaw : null;

        if ($nombre === '') {
            Session::flash('error', 'El nombre del producto es obligatorio.');
            $this->redirect('/admin/productos/nuevo');
        }

        $productModel = new Product();
        $slug = $productModel->generarSlugUnico($nombre);
        $id = $productModel->create($nombre, $slug, $descripcion, $precio, $destacado, $categoryId);

        $this->guardarImagenes($id);

        Session::flash('exito', 'Producto creado correctamente.');
        $this->redirect('/admin/productos');
    }

    public function edit(string $id): void
    {
        AuthMiddleware::handle();

        $productModel = new Product();
        $producto = $productModel->findById((int) $id);

        if (!$producto) {
            $this->notFound();
        }

        $this->render('admin/productos/form', [
            'titulo' => 'Editar producto',
            'producto' => $producto,
            'categorias' => (new Category())->all(),
        ], layout: 'layouts/admin');
    }

    public function update(string $id): void
    {
        AuthMiddleware::handle();
        CsrfMiddleware::verify();

        $productModel = new Product();
        $producto = $productModel->findById((int) $id);
        if (!$producto) {
            $this->notFound();
        }

        $nombre = Request::input('nombre');
        $descripcion = Request::input('descripcion');
        $precioRaw = Request::input('precio');
        $precio = $precioRaw !== '' ? (float) $precioRaw : null;
        $destacado = Request::input('destacado') === '1';
        $categoryIdRaw = Request::input('category_id');
        $categoryId = $categoryIdRaw !== '' ? (int) $categoryIdRaw : null;

        $productModel->update((int) $id, $nombre, $descripcion, $precio, $destacado, $categoryId);
        $this->guardarImagenes((int) $id);

        Session::flash('exito', 'Producto actualizado correctamente.');
        $this->redirect('/admin/productos');
    }

    public function destroyImage(string $id, string $imagenId): void
    {
        AuthMiddleware::handle();
        CsrfMiddleware::verify();

        (new ProductImage())->eliminar((int) $imagenId, (int) $id);

        Session::flash('exito', 'Imagen eliminada.');
        $this->redirect('/admin/productos/' . $id . '/editar');
    }

    public function setImagenPrincipal(string $id, string $imagenId): void
    {
        AuthMiddleware::handle();
        CsrfMiddleware::verify();

        (new ProductImage())->hacerPrincipal((int) $imagenId, (int) $id);

        Session::flash('exito', 'Imagen principal actualizada.');
        $this->redirect('/admin/productos/' . $id . '/editar');
    }

    public function optimizarImagen(string $id, string $imagenId): void
    {
        AuthMiddleware::handle();
        CsrfMiddleware::verify();

        $ok = (new ProductImage())->optimizarAWebp((int) $imagenId, (int) $id);
        Session::flash($ok ? 'exito' : 'error', $ok
            ? 'Imagen convertida a WebP correctamente.'
            : 'No se pudo convertir la imagen a WebP.');

        $this->redirect('/admin/productos/' . $id . '/editar');
    }

    public function toggleDestacado(string $id): void
    {
        AuthMiddleware::handle();
        CsrfMiddleware::verify();

        (new Product())->toggleDestacado((int) $id);
        $this->redirect('/admin/productos');
    }

    public function destroy(string $id): void
    {
        AuthMiddleware::handle();
        CsrfMiddleware::verify();

        $productId = (int) $id;
        (new ProductImage())->eliminarCarpetaProducto($productId);
        (new Product())->delete($productId);

        Session::flash('exito', 'Producto eliminado.');
        $this->redirect('/admin/productos');
    }

    private function guardarImagenes(int $productId): void
    {
        $archivos = Request::file('imagenes');
        if (!$archivos || empty($archivos['name'][0])) {
            return;
        }

        $imageModel = new ProductImage();
        $productModel = new Product();
        $existente = $productModel->findById($productId);
        $orden = $existente ? count($existente['imagenes']) : 0;

        foreach ($archivos['tmp_name'] as $indice => $tmpName) {
            if (($archivos['error'][$indice] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
                continue;
            }

            $archivo = [
                'name' => $archivos['name'][$indice],
                'tmp_name' => $tmpName,
                'size' => $archivos['size'][$indice],
                'error' => $archivos['error'][$indice],
            ];

            $imageModel->agregarDesdeUpload($productId, $archivo, $orden);
            $orden++;
        }
    }
}
