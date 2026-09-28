<?php

final class AuthMiddleware
{
    public static function handle(): void
    {
        if (!Auth::check()) {
            redirect('/admin/login');
        }
    }
}
