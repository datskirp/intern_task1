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

    public function total(): float
    {
        $sum = 0;
        foreach ($this->cart as $product) {
            $sum += $product->getCost() + $product->servicesSubtotal();
        }

        return $sum;
    }
}
