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
        return trim($_SERVER['REQUEST_URI'], '/');
    }

    public function getRoute(): array
    {
        return $this->routes;
    }

    public function getFile(): ?array
    {
        return $_FILES;
    }
}
