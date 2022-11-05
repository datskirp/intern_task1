<?php

namespace App\Models\Cart;

use App\Models\AddableToCartInterface;
use App\Services\Db;

class UserCart extends AbstractCart implements CartInterface
{
    private int $id;
    private int $userId;
    public static $db;
    public const USER_CART = 'cart';

    public function __construct(int $userId)
    {
        self::$db = Db::getInstance();

        if (self::isCartSaved($userId) == false) {
            $this->id = time();
            $this->userId = $userId;
            self::$db->insert(self::USER_CART)
                ->columns(['id', 'user_id', 'cart'])
                ->values(['id' => $this->id, 'user_id' => $this->userId, 'cart' => serialize($this->cart)])
                ->do();
        }
    }


    public function addItem(AddableToCartInterface $item)
    {
        $this->cart[$item->getId()] = $item;
        $this->update();
    }

    public function removeItem(AddableToCartInterface $item)
    {
        unset($this->cart[$item->getId()]);
        $this->update();
    }

    public function addService(AddableToCartInterface $service, int $productId)
    {
        $this->cart[$productId]->addService($service);
        $this->update();
    }

    public function removeService(int $productId, int $serviceId)
    {
        $this->cart[$productId]->removeService($serviceId);
        $this->update();
    }

    public static function isCartSaved(int $user_id)
    {
        return self::$db->select()->from(self::USER_CART)
            ->where(['user_id' => $user_id], '= :')
            ->getOne();
    }

    public function loadFromDb($userId)
    {
        $saved_card = self::$db->select()
            ->from(self::USER_CART)
            ->where(['user_id' => $userId], '= :')
            ->getOne();
        if ($saved_card) {
            $this->id = $saved_card['id'];
            $this->userId = $userId;
            $this->cart = unserialize($saved_card['cart']);
        }
    }

    public function update()
    {
        $db = Db::getInstance();
        $db->update(self::USER_CART)
            ->set(['cart' => serialize($this->cart)])
            ->where(['user_id' => $this->userId], '= :')
            ->do();
    }
}
