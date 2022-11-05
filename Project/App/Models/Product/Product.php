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
    private int $quantity;
    private array $services = [];

    protected static function getTableName(): string
    {
        return 'products';
    }

    public function getItem(int $id)
    {
        return self::getByIdObject($id);
    }

    public function getAll(): ?array
    {
        return $this->getAllObject();
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
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

    public function getServices(): array
    {
        return $this->services;
    }

    public function addService(AddableToCartInterface $service)
    {
        $this->services[] = $service;
    }


}