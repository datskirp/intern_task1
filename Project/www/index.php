<?php

use App\Router;

spl_autoload_register(function (string $className) {
    require_once __DIR__ . '/../' . str_replace('\\', '/', $className) . '.php';
});

$router = new Router();
if (!is_null($router->getController())){
    $controllerName = $router->getController()[0];
    $controllerAction = $router->getController()[1];
    $args = $router->getController()[2];
    $controller = new $controllerName();
    $args ? $controller->$controllerAction(...$args) : $controller->$controllerAction();
} else {
    echo 'Page is not found.';
}


