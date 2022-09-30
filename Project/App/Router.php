<?php
namespace App;

class Router
{
    public function getController(): ?array
    {
        $routes = require __DIR__ . '/../Config/routes.php';
        $route = explode('/', $_SERVER['REQUEST_URI']);
        $args = [];
        for ($i = 3; $i < count($route); $i++) {
            $args[] = $route[$i] ?? '';
        }
        $route = count($route) <= 3  ? $route : array_slice($route, 0, 3);
        var_dump($route);
        var_dump($args);
        foreach ($routes as $path => $controllerAndAction) {
            $path = explode('/', $path);
            if ($path == $route) {
                var_dump($path);
                var_dump($args);
                $controllerAndAction[] = $args;
                return $controllerAndAction;
            }
        }
        return null;
    }
}