<?php

namespace App\Models\Cart;

use App\Models\AddableToCartInterface;

class GuestCart extends AbstractCart
{

    public function addItem(AddableToCartInterface $item)
    {
        // TODO: Implement addItem() method.
    }

    public function removeItem(AddableToCartInterface $item)
    {
        // TODO: Implement removeItem() method.
    }

    public function getCart(): CartInterface
    {
        // TODO: Implement getCart() method.
    }
}