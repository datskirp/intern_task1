<?php

namespace App;

class Router
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getCallback(): array|false
    {
        foreach ($this->request->getRoute() as $route => $controllerAndAction) {
            if ($route === '/') {
                return $controllerAndAction;
            }
        }
        return false;
    }
}
