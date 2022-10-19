<?php

namespace App;

class Router
{
    private $request;
    private array $routes;

    public function __construct(Request $request, array $routes)
    {
        $this->request = $request;
        $this->routes = $routes[$this->request::getMethod()];
    }

    public function getCallback(): array|false
    {
        foreach ($this->routes as $route => $controllerAndAction) {
            if ($route === $this->request::getUri()) {
                return $controllerAndAction;
            }
        }

        return false;
    }
}
