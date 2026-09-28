<?php

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function csrf_token(): string
{
    if (!Session::get('_csrf_token')) {
        Session::set('_csrf_token', bin2hex(random_bytes(32)));
    }

    return Session::get('_csrf_token');
}

function csrf_field(): string
{
    return '<input type="hidden" name="_csrf" value="' . e(csrf_token()) . '">';
}

function csrf_verify(): bool
{
    $token = $_POST['_csrf'] ?? '';
    return is_string($token) && hash_equals(csrf_token(), $token);
}

function whatsapp_link(string $mensaje = ''): string
{
    $numero = Env::get('WHATSAPP_NUMERO', '573188763377');
    $texto = $mensaje !== '' ? $mensaje : 'Hola, estoy interesado en sus productos de tacos de billar.';
    return 'https://wa.me/' . $numero . '?text=' . rawurlencode($texto);
}

function old(string $key, string $default = ''): string
{
    return e($_SESSION['_old'][$key] ?? $default);
}

function redirect(string $path): never
{
    header('Location: ' . $path, true, 302);
    exit;
}

function app_log(string $message): void
{
    $line = '[' . date('Y-m-d H:i:s') . '] ' . $message . PHP_EOL;
    error_log($line, 3, __DIR__ . '/../../storage/logs/app.log');
}
