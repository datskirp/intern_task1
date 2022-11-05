<?php

namespace App\Controllers\Cart;


class CartController extends \App\Controllers\BaseController
{
    public function index(): string
    {
        $services = $this->services->getAllObject();
        return $this->view->render('User/Cart.twig',
            [
                'title' => 'Your cart',
                'cart' => $this->session->getCart()->getItems(),
                'services' => $services,
            ]);
    }
    public function addProduct($args)
    {
        $post_vars = json_decode(file_get_contents('php://input'), true);
        $product = $this->product::getByIdObject($args['id']);
        //$product->setQuantity($post_vars['quantity']);
        $this->session->getCart()->addItem($product);

        return $this->response->send(true, '/', [], null, $this->session->getCart()->count());
    }

    public function deleteProduct($args)
    {
        //$product->setQuantity($post_vars['quantity']);
        $this->session->getCart()->removeItem($args['id']);

        return $this->response->send(true, '/cart');
    }

}