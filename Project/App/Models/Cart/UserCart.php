<?php

namespace App\Models\Cart;

use App\Models\AddableToCartInterface;

class UserCart extends AbstractCart implements CartInterface
{
    private int $id;
    private int $userId;

    /**
     * @param int $id
     * @param int $userId
     */
    public function __construct(int $userId)
    {
        $this->id = time();
        $this->userId = $userId;
    }


    public function addItem(AddableToCartInterface $item)
    {
        // TODO: Implement addItem() method.
    }

    public function removeItem(AddableToCartInterface $item)
    {
        // TODO: Implement removeItem() method.
    }
}