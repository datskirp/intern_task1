<?php

namespace App\Models\Service;

class Service extends \App\Models\AbstractModel implements \App\Models\AddableToCartInterface
{
    private int $id;
    private string $type;
    private float $cost;
    private int $deadline;
    private string $category;

    protected static function getTableName(): string
    {
        return 'services';
    }

    public function getItem(int $id)
    {
        return self::getByIdObject($id);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getCost(): float
    {
        return $this->cost;
    }

    public function getDeadline(): int
    {
        return $this->deadline;
    }

    public function getCategory(): string
    {
        return $this->category;
    }
}
