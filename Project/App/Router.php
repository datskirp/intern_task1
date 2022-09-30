<?php
namespace App;

class Router
{
    public function getController(): ?array
    {
        $routes = require __DIR__ . '/../Config/routes.php';
        $route = explode('/', $_SERVER['REQUEST_URI']);
        $args = [];
        for ($i = 2; $i < count($route); $i++) {
            $args[] = $route[$i] ?? '';
        }
        $route = count($route) == 2  ? $route : array_slice($route, 0, 3);
        foreach ($routes as $path => $controllerAndAction) {
            $path = explode('/', $path);
            if ($path == $route) {
                $controllerAndAction[] = $args;
                return $controllerAndAction;
            }
        }
        return null;
    }
}