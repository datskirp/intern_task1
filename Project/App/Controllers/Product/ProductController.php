<?php

namespace App\Controllers\Product;

class ProductController extends \App\Controllers\BaseController
{
    public function index(array $args = []): string
    {
        $args['user'] = $this->user::getByIdObject($this->session->getId());
        $args['cartCount'] = $this->session->getCart()->count();

        return $this->view->render('User/Catalog.twig', ['products' => $this->product->getAll(), 'args' => $args]);
    }

    public function card(array $args = []): string
    {
        $args['user'] = $this->user::getByIdObject($this->session->getId());
        $args['cartCount'] = $this->session->getCart()->count();

        return $this->view->render('User/Card.twig', ['product' => $this->product->getItem($args['id']), 'args' => $args]);
    }
}
