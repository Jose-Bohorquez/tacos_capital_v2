<?php

final class HomeController extends Controller
{
    public function index(): void
    {
        $productModel = new Product();
        $productos = $productModel->destacados(8);
        if (empty($productos)) {
            // Si aún no se ha marcado ningún producto como destacado, mostramos los más recientes
            $productos = array_slice($productModel->all(), 0, 8);
        }

        $this->render('home/index', [
            'titulo' => 'Tacos de Billar en Bogotá — Venta y Reparación',
            'descripcion' => 'Tacos de billar profesionales y para principiantes en Bogotá. Reparación, cambio de virolas y suelas, y personalización. Envíos a toda Colombia.',
            'canonical' => Env::get('APP_URL') . '/',
            'productosDestacados' => $productos,
        ]);
    }
}
