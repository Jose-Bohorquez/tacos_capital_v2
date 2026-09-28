<?php

final class SitemapController extends Controller
{
    public function index(): void
    {
        header('Content-Type: application/xml; charset=utf-8');

        $productos = (new Product())->all();
        $baseUrl = Env::get('APP_URL');

        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        $estaticas = [
            ['loc' => '/', 'prioridad' => '1.0', 'frecuencia' => 'weekly'],
            ['loc' => '/productos', 'prioridad' => '0.8', 'frecuencia' => 'weekly'],
            ['loc' => '/contacto', 'prioridad' => '0.7', 'frecuencia' => 'monthly'],
        ];

        foreach ($estaticas as $pagina) {
            echo "  <url><loc>{$baseUrl}{$pagina['loc']}</loc><changefreq>{$pagina['frecuencia']}</changefreq><priority>{$pagina['prioridad']}</priority></url>\n";
        }

        foreach ($productos as $producto) {
            $loc = $baseUrl . '/producto/' . e($producto['slug']);
            $lastmod = $producto['updated_at'] ?? $producto['created_at'];
            $fecha = date('Y-m-d', strtotime((string) $lastmod));
            echo "  <url><loc>{$loc}</loc><lastmod>{$fecha}</lastmod><changefreq>monthly</changefreq><priority>0.6</priority></url>\n";
        }

        echo '</urlset>';
    }
}
