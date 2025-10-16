<?php

namespace App\Controllers;

use PDO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ProductoController
{
    private PDO $pdo;
    private $templates;

    public function __construct(PDO $pdo, $templates)
    {
        $this->pdo = $pdo;
        $this->templates = $templates;
    }

    /**
     * Obtener todos los productos con paginación (Vista HTML)
     */
    public function index(Request $request, Response $response): Response
    {
        $params = $request->getQueryParams();
        $page = (int)($params['page'] ?? 1);
        $limit = (int)($params['limit'] ?? 12);
        $offset = ($page - 1) * $limit;

        try {
            // Contar total de productos activos
            $countStmt = $this->pdo->prepare("
                SELECT COUNT(*) as total 
                FROM productos 
                WHERE activo = 1
            ");
            $countStmt->execute();
            $total = $countStmt->fetch()['total'];

            // Obtener productos con sus medias
            $stmt = $this->pdo->prepare("
                SELECT 
                    p.id,
                    p.nombre,
                    p.descripcion,
                    p.precio,
                    p.slug,
                    p.destacado,
                    p.portada,
                    p.created_at,
                    GROUP_CONCAT(
                        CASE WHEN pm.tipo = 'imagen' 
                        THEN CONCAT(pm.id, ':', pm.archivo, ':', pm.orden) 
                        END ORDER BY pm.orden ASC SEPARATOR '|'
                    ) as imagenes,
                    GROUP_CONCAT(
                        CASE WHEN pm.tipo = 'video' 
                        THEN CONCAT(pm.id, ':', pm.archivo, ':', pm.orden) 
                        END ORDER BY pm.orden ASC SEPARATOR '|'
                    ) as videos
                FROM productos p
                LEFT JOIN producto_media pm ON p.id = pm.producto_id
                WHERE p.activo = 1
                GROUP BY p.id
                ORDER BY p.destacado DESC, p.created_at DESC
                LIMIT :limit OFFSET :offset
            ");
            
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            
            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Procesar las imágenes y videos
            foreach ($productos as &$producto) {
                $producto['imagenes'] = $this->processMedia($producto['imagenes']);
                $producto['videos'] = $this->processMedia($producto['videos']);
                $producto['precio_formateado'] = number_format($producto['precio'], 0, ',', '.');
            }

            $pagination = [
                'current_page' => $page,
                'total_pages' => ceil($total / $limit),
                'total_items' => $total,
                'items_per_page' => $limit
            ];

            // Renderizar vista HTML
            $html = $this->templates->render('productos', [
                'productos' => $productos,
                'pagination' => $pagination
            ]);

            $response->getBody()->write($html);
            return $response;

        } catch (\Exception $e) {
            $response->getBody()->write('Error al cargar productos: ' . $e->getMessage());
            return $response->withStatus(500);
        }
    }

    /**
     * API JSON para obtener todos los productos con paginación
     */
    public function indexApi(Request $request, Response $response): Response
    {
        $params = $request->getQueryParams();
        $page = (int)($params['page'] ?? 1);
        $limit = (int)($params['limit'] ?? 12);
        $offset = ($page - 1) * $limit;

        try {
            // Contar total de productos activos
            $countStmt = $this->pdo->prepare("
                SELECT COUNT(*) as total 
                FROM productos 
                WHERE activo = 1
            ");
            $countStmt->execute();
            $total = $countStmt->fetch()['total'];

            // Obtener productos con sus medias
            $stmt = $this->pdo->prepare("
                SELECT 
                    p.id,
                    p.nombre,
                    p.descripcion,
                    p.precio,
                    p.slug,
                    p.destacado,
                    p.portada,
                    p.created_at,
                    GROUP_CONCAT(
                        CASE WHEN pm.tipo = 'imagen' 
                        THEN CONCAT(pm.id, ':', pm.archivo, ':', pm.orden) 
                        END ORDER BY pm.orden ASC SEPARATOR '|'
                    ) as imagenes,
                    GROUP_CONCAT(
                        CASE WHEN pm.tipo = 'video' 
                        THEN CONCAT(pm.id, ':', pm.archivo, ':', pm.orden) 
                        END ORDER BY pm.orden ASC SEPARATOR '|'
                    ) as videos
                FROM productos p
                LEFT JOIN producto_media pm ON p.id = pm.producto_id
                WHERE p.activo = 1
                GROUP BY p.id
                ORDER BY p.destacado DESC, p.created_at DESC
                LIMIT :limit OFFSET :offset
            ");
            
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            
            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Procesar las imágenes y videos
            foreach ($productos as &$producto) {
                $producto['imagenes'] = $this->processMedia($producto['imagenes']);
                $producto['videos'] = $this->processMedia($producto['videos']);
                $producto['precio_formateado'] = number_format($producto['precio'], 0, ',', '.');
            }

            $data = [
                'productos' => $productos,
                'pagination' => [
                    'current_page' => $page,
                    'total_pages' => ceil($total / $limit),
                    'total_items' => $total,
                    'items_per_page' => $limit
                ]
            ];

            $response->getBody()->write(json_encode($data));
            return $response->withHeader('Content-Type', 'application/json');

        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    /**
     * Obtener productos destacados para la landing page
     */
    public function destacados(Request $request, Response $response): Response
    {
        $params = $request->getQueryParams();
        $limit = (int)($params['limit'] ?? 6);

        try {
            $stmt = $this->pdo->prepare("
                SELECT 
                    p.id,
                    p.nombre,
                    p.descripcion,
                    p.precio,
                    p.slug,
                    p.destacado,
                    p.portada,
                    GROUP_CONCAT(
                        CASE WHEN pm.tipo = 'imagen' 
                        THEN CONCAT(pm.id, ':', pm.archivo, ':', pm.orden) 
                        END ORDER BY pm.orden ASC SEPARATOR '|'
                    ) as imagenes
                FROM productos p
                LEFT JOIN producto_media pm ON p.id = pm.producto_id
                WHERE p.activo = 1
                GROUP BY p.id
                ORDER BY p.destacado DESC, p.created_at DESC
                LIMIT :limit
            ");
            
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            
            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Procesar las imágenes
            foreach ($productos as &$producto) {
                $producto['imagenes'] = $this->processMedia($producto['imagenes']);
                $producto['precio_formateado'] = number_format($producto['precio'], 0, ',', '.');
                $producto['descripcion_corta'] = substr($producto['descripcion'], 0, 100) . '...';
            }

            $response->getBody()->write(json_encode($productos));
            return $response->withHeader('Content-Type', 'application/json');

        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    /**
     * Obtener un producto por su slug (Vista HTML)
     */
    public function show(Request $request, Response $response, array $args): Response
    {
        $slug = $args['slug'];

        try {
            $stmt = $this->pdo->prepare("
                SELECT 
                    p.id,
                    p.nombre,
                    p.descripcion,
                    p.precio,
                    p.slug,
                    p.stock,
                    p.destacado,
                    p.portada,
                    p.created_at,
                    c.nombre as categoria_nombre,
                    GROUP_CONCAT(
                        CASE WHEN pm.tipo = 'imagen' 
                        THEN CONCAT(pm.id, ':', pm.archivo, ':', pm.orden) 
                        END ORDER BY pm.orden ASC SEPARATOR '|'
                    ) as imagenes,
                    GROUP_CONCAT(
                        CASE WHEN pm.tipo = 'video' 
                        THEN CONCAT(pm.id, ':', pm.archivo, ':', pm.orden) 
                        END ORDER BY pm.orden ASC SEPARATOR '|'
                    ) as videos
                FROM productos p
                LEFT JOIN categorias c ON p.categoria_id = c.id
                LEFT JOIN producto_media pm ON p.id = pm.producto_id
                WHERE p.slug = :slug AND p.activo = 1
                GROUP BY p.id
            ");
            
            $stmt->bindValue(':slug', $slug);
            $stmt->execute();
            
            $producto = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$producto) {
                $response->getBody()->write('Producto no encontrado');
                return $response->withStatus(404);
            }

            // Procesar las imágenes y videos
            $producto['imagenes'] = $this->processMedia($producto['imagenes']);
            $producto['videos'] = $this->processMedia($producto['videos']);
            $producto['precio_formateado'] = number_format($producto['precio'], 0, ',', '.');

            // Renderizar vista HTML
            $html = $this->templates->render('producto', [
                'producto' => $producto
            ]);

            $response->getBody()->write($html);
            return $response;

        } catch (\Exception $e) {
            $response->getBody()->write('Error al cargar producto: ' . $e->getMessage());
            return $response->withStatus(500);
        }
    }

    /**
     * API JSON para obtener un producto por su slug
     */
    public function showApi(Request $request, Response $response, array $args): Response
    {
        $slug = $args['slug'];

        try {
            $stmt = $this->pdo->prepare("
                SELECT 
                    p.id,
                    p.nombre,
                    p.descripcion,
                    p.precio,
                    p.slug,
                    p.stock,
                    p.destacado,
                    p.portada,
                    p.created_at,
                    c.nombre as categoria_nombre,
                    GROUP_CONCAT(
                        CASE WHEN pm.tipo = 'imagen' 
                        THEN CONCAT(pm.id, ':', pm.archivo, ':', pm.orden) 
                        END ORDER BY pm.orden ASC SEPARATOR '|'
                    ) as imagenes,
                    GROUP_CONCAT(
                        CASE WHEN pm.tipo = 'video' 
                        THEN CONCAT(pm.id, ':', pm.archivo, ':', pm.orden) 
                        END ORDER BY pm.orden ASC SEPARATOR '|'
                    ) as videos
                FROM productos p
                LEFT JOIN categorias c ON p.categoria_id = c.id
                LEFT JOIN producto_media pm ON p.id = pm.producto_id
                WHERE p.slug = :slug AND p.activo = 1
                GROUP BY p.id
            ");
            
            $stmt->bindValue(':slug', $slug);
            $stmt->execute();
            
            $producto = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$producto) {
                $response->getBody()->write(json_encode(['error' => 'Producto no encontrado']));
                return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
            }

            // Procesar las imágenes y videos
            $producto['imagenes'] = $this->processMedia($producto['imagenes']);
            $producto['videos'] = $this->processMedia($producto['videos']);
            $producto['precio_formateado'] = number_format($producto['precio'], 0, ',', '.');

            $response->getBody()->write(json_encode($producto));
            return $response->withHeader('Content-Type', 'application/json');

        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    /**
     * Renderizar la landing page
     */
    public function landing(Request $request, Response $response): Response
    {
        try {
            // Obtener productos destacados con consulta simplificada
            $stmt = $this->pdo->prepare("
                SELECT id, nombre, descripcion, precio, slug, destacado, portada
                FROM productos 
                WHERE activo = 1 AND destacado = 1
                ORDER BY created_at DESC
                LIMIT 6
            ");
            
            $stmt->execute();
            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Procesar datos básicos
            foreach ($productos as &$producto) {
                $producto['precio_formateado'] = '$' . number_format($producto['precio'], 0, ',', '.');
                $producto['descripcion_corta'] = strlen($producto['descripcion']) > 100 
                    ? substr($producto['descripcion'], 0, 100) . '...' 
                    : $producto['descripcion'];
                
                // Agregar imagen por defecto si no tiene portada
                if (empty($producto['portada'])) {
                    $producto['portada'] = '/assets/img/default-product.svg';
                }
                
                // Crear estructura de imágenes para compatibilidad con la vista
                $producto['imagenes'] = [
                    ['url' => $producto['portada']]
                ];
            }

            $html = $this->templates->render('landing', [
                'productos' => $productos,
                'titulo' => 'Inicio',
                'descripcion' => 'Tacos Capital - Especialistas en tacos de billar de alta calidad. Venta, reparación y personalización de tacos, virolas y suelas para mejorar tu juego.',
                'keywords' => 'tacos de billar, tacos profesionales, virolas, suelas, reparación de tacos, personalización de tacos, billar, pool, accesorios de billar',
                'canonical' => 'https://tacoscapital.online/',
                'ogImage' => 'https://tacoscapital.online/assets/img/og-image.jpg'
            ]);

            $response->getBody()->write($html);
            return $response;

        } catch (\Exception $e) {
            $response->getBody()->write('Error en landing: ' . $e->getMessage());
            return $response->withStatus(500);
        }
    }

    /**
     * Procesar cadena de media (imágenes o videos) en array
     */
    private function processMedia(?string $mediaString): array
    {
        if (!$mediaString) {
            return [];
        }

        $media = [];
        $items = explode('|', $mediaString);
        
        foreach ($items as $item) {
            if (empty($item)) continue;
            
            $parts = explode(':', $item);
            if (count($parts) >= 3) {
                $archivo = $parts[1];
                
                // Si el archivo ya contiene la ruta completa, usarla directamente
                // Si no, agregar el prefijo /media/productos/
                $url = (strpos($archivo, '/media/productos/') === 0) 
                    ? $archivo 
                    : '/media/productos/' . $archivo;
                
                $media[] = [
                    'id' => $parts[0],
                    'archivo' => $archivo,
                    'orden' => $parts[2],
                    'url' => $url
                ];
            }
        }

        return $media;
    }
}