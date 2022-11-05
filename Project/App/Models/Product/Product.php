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

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getManufacturer(): string
    {
        return $this->manufacturer;
    }

    public function getRelease(): string
    {
        return $this->release;
    }

    public function getCost(): float
    {
        return $this->cost;
    }

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
        $this->services[$service->getId()] = $service;
    }

    public function removeService(int $id): void
    {
        unset($this->services[$id]);
    }

    public function servicesSubtotal()
    {
        $sum = 0;
        foreach ($this->services as $service) {
            $sum += $service->getCost();
        }

        return round($sum, 2);
    }
}
