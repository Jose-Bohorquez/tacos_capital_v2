<?php

final class ContactController extends Controller
{
    public function index(): void
    {
        $this->render('contacto/index', [
            'titulo' => 'Contacto',
            'descripcion' => 'Contáctanos para obtener más información sobre nuestros tacos de billar. Estamos para ayudarte a encontrar el taco perfecto.',
            'canonical' => Env::get('APP_URL') . '/contacto',
        ]);
    }
}
