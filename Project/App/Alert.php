<?php

namespace App;

class Alert
{
    private array $alerts = [];

    public function setAlerts(string $field, string $value): void
    {
        $this->alerts[$field] = $value;
    }

    public function getAlerts():array
    {
        return $this->alerts;
    }

    public function resetAlerts(): void
    {
        $this->alerts = [];
    }
}