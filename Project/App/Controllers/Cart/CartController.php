<?php

namespace App\Controllers\Cart;

class CartController extends \App\Controllers\BaseController
{
    public function index(): string
    {
        $services = $this->services->getAllObject();

        return $this->view->render(
            'User/Cart.twig',
            [
                'title' => 'Your cart',
                'cart' => $this->session->getCart(),
                'services' => $services,
                'user' => $this->session->getId(),
            ]
        );
    }
    public function addProduct($args): string
    {
        $product = $this->product::getByIdObject($args['id']);
        $this->session->getCart()->addItem($product);

        return $this->response->send(true, '/', [], $args['id'], $this->session->getCart()->count());
    }

    public function deleteProduct($args): string
    {
        $product = $this->product::getByIdObject($args['id']);
        $this->session->getCart()->removeItem($product);

        return $this->response->send(true, '/cart', [], null, $this->session->getCart()->count());
    }

    public function addService($args): string
    {
        $post_vars = json_decode(file_get_contents('php://input'), true);
        $service = $this->services->getItem($args['id']);
        $this->session->getCart()->addService($service, $post_vars['productId']);

        return $this->response->send(true, '/cart');
    }

    public function deleteService($args): string
    {
        $post_vars = json_decode(file_get_contents('php://input'), true);
        $this->session->getCart()->removeService($post_vars['productId'], $args['id']);

        return $this->response->send(true, '/cart');
    }
}
