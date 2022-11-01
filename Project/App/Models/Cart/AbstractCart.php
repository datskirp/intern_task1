<?php

namespace App\Models\Cart;

use App\Models\AddableToCartInterface;

abstract class AbstractCart
{
    protected $cart;
    abstract public function addItem(AddableToCartInterface $item);
    abstract public function removeItem(AddableToCartInterface $item);
    abstract public function getCart(): CartInterface;

}