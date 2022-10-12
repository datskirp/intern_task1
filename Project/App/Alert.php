<?php

namespace App;

class Alert
{
    private array $alerts = [];
    private static $instance;

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function setAlerts(string $field, string $value): void
    {
        $this->alerts[$field] = $value;
    }

    public function getAlerts(): array
    {
        return $this->alerts;
    }

    public function resetAlerts(): void
    {
        $this->alerts = [];
    }
}
