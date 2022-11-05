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
        // TODO: Implement getItem() method.
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
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return float
     */
    public function getCost(): float
    {
        return $this->cost;
    }

    /**
     * @return int
     */
    public function getDeadline(): int
    {
        return $this->deadline;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }


}