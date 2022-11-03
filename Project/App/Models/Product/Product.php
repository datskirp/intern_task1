<?php

namespace App\Models\Product;

use App\Models\AddableToCartInterface;

class Product extends \App\Models\AbstractModel implements AddableToCartInterface
{
    private int $id;
    private string $name;
    private string $manufacturer;
    private string $release;
    private float $cost;
    private string $category;

    protected static function getTableName(): string
    {
        return 'products';
    }

    public function getItem()
    {
        // TODO: Implement getItem() method.
    }

    public function getAll(): ?array
    {
        return $this->getAllObject();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getManufacturer(): string
    {
        return $this->manufacturer;
    }

    /**
     * @return string
     */
    public function getRelease(): string
    {
        return $this->release;
    }

    /**
     * @return float
     */
    public function getCost(): float
    {
        return $this->cost;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }


}