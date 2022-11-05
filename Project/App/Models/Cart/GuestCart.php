<?php

namespace App\Models\Cart;

use App\Models\AddableToCartInterface;

class GuestCart extends AbstractCart implements CartInterface
{

    public function addItem(AddableToCartInterface $item)
    {
        $this->cart[$item->getId()] = $item;
    }

    public function removeItem(AddableToCartInterface $item)
    {
        unset($this->cart[$item->getId()]);
    }

}