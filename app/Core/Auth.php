<?php

final class Auth
{
    private const SESSION_TIMEOUT = 1800; // 30 minutos, mismo criterio que el sitio anterior

    public static function attempt(string $username, string $password): bool
    {
        $admin = new \Admin();
        $record = $admin->findByUsername($username);

        if (!$record || !password_verify($password, $record['password_hash'])) {
            usleep(300000); // mitiga timing/brute-force básico
            return false;
        }

        Session::regenerate();
        Session::set('admin_id', $record['id']);
        Session::set('admin_username', $record['username']);
        Session::set('admin_ip', $_SERVER['REMOTE_ADDR'] ?? '');
        Session::set('admin_last_activity', time());

        return true;
    }

    public static function check(): bool
    {
        if (!Session::get('admin_id')) {
            return false;
        }

        if (Session::get('admin_ip') !== ($_SERVER['REMOTE_ADDR'] ?? '')) {
            self::logout();
            return false;
        }

        $lastActivity = Session::get('admin_last_activity', 0);
        if (time() - $lastActivity > self::SESSION_TIMEOUT) {
            self::logout();
            return false;
        }

        Session::set('admin_last_activity', time());
        return true;
    }

    public static function logout(): void
    {
        Session::destroy();
    }
}
