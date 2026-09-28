<?php

final class AdminAuthController extends Controller
{
    public function showLogin(): void
    {
        if (Auth::check()) {
            $this->redirect('/admin');
        }

        $this->render('admin/login', ['titulo' => 'Acceso administrador'], layout: 'layouts/admin-guest');
    }

    public function login(): void
    {
        CsrfMiddleware::verify();

        $usuario = Request::input('username');
        $password = Request::input('password');

        if (Auth::attempt($usuario, $password)) {
            $this->redirect('/admin');
        }

        Session::flash('error', 'Usuario o contraseña incorrectos.');
        $this->redirect('/admin/login');
    }

    public function logout(): void
    {
        Auth::logout();
        $this->redirect('/admin/login');
    }
}
