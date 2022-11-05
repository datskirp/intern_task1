<?php

namespace App\Models\Cart;

use App\Models\AddableToCartInterface;

abstract class AbstractCart
{
    protected $cart = [];

    public function count(): int
    {
        return count($this->cart);
    }
    public function getItems()
    {
        return $this->cart;
    }

    public function addService(AddableToCartInterface $service, int $productId)
    {
        $this->cart[$productId]->addService($service);
    }

    public function removeService(int $productId, int $serviceId)
    {
        $this->cart[$productId]->removeService($serviceId);
    }
}
