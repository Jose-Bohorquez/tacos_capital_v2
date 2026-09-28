<?php

final class CsrfMiddleware
{
    public static function verify(): void
    {
        if (Request::method() === 'POST' && !csrf_verify()) {
            http_response_code(419);
            exit('Token de seguridad inválido o expirado. Recarga la página e intenta de nuevo.');
        }
    }
}
