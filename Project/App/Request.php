<?php

namespace App;

class Request
{
    private array $routes;

    public function __construct(array $routes)
    {
        $this->routes = $routes[self::getMethod()];
    }


    public static function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function getUri(): string
    {
        return trim($this->getUri(), '/');
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }
}
