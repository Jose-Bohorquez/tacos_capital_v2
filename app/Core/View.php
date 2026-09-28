<?php

final class View
{
    public static function render(string $view, array $data = [], string $layout = 'layouts/main'): void
    {
        $viewsPath = __DIR__ . '/../Views/';
        extract($data, EXTR_SKIP);

        $content = self::capture($viewsPath . $view . '.php', $data);

        if ($layout !== '') {
            self::capture($viewsPath . $layout . '.php', array_merge($data, ['content' => $content]), true);
            return;
        }

        echo $content;
    }

    private static function capture(string $file, array $data, bool $echo = false): string
    {
        if (!is_file($file)) {
            throw new RuntimeException("Vista no encontrada: {$file}");
        }

        extract($data, EXTR_SKIP);
        if ($echo) {
            require $file;
            return '';
        }

        ob_start();
        require $file;
        return ob_get_clean();
    }
}
