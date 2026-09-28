<?php

final class AdminDashboardController extends Controller
{
    public function index(): void
    {
        AuthMiddleware::handle();

        $productModel = new Product();
        $productos = $productModel->all();
        $sinImagenes = count(array_filter($productos, fn($p) => empty($p['imagenes'])));

        $this->render('admin/dashboard', [
            'titulo' => 'Panel de administración',
            'totalProductos' => count($productos),
            'totalDestacados' => count($productModel->destacados(999)),
            'sinImagenes' => $sinImagenes,
        ], layout: 'layouts/admin');
    }
}
