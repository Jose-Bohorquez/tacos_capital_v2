<?php

abstract class Controller
{
    protected function render(string $view, array $data = [], string $layout = 'layouts/main'): void
    {
        View::render($view, $data, $layout);
    }

    protected function redirect(string $path): never
    {
        redirect($path);
    }

    protected function notFound(): never
    {
        http_response_code(404);
        View::render('errors/404', []);
        exit;
    }
}
