<?php

namespace App\Controllers\Product;

class ProductController extends \App\Controllers\BaseController
{
    public function index(array $args = []): string
    {
        $flash = $this->session::getFlash('action');
        if ($flash) {
            $args['flash'] = $flash;
        }
        /*
        $args['user'] = $this->user::getByIdObject($args['user']);
        if (is_null($args['user'])) {
            $arg['user']['id'] = 0; // Guest user
        }
        */
        return $this->view->render('User/Catalog.twig', ['products' => $this->product->getAll(), 'args' => $args]);
    }

}