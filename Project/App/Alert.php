<?php

namespace App;

class Alert
{
    private array $alerts = [];

    public function setAlerts(array $alert): void
    {
        $this->alerts += $alert;
    }

    public function getAlerts():array
    {
        return $this->alerts;
    }
}