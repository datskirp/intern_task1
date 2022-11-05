<?php

namespace App\Models\Cart;

use App\Models\AddableToCartInterface;

interface CartInterface
{
    public function addItem(AddableToCartInterface $item);
    public function removeItem(AddableToCartInterface $item);
}
