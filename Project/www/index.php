<?php

use App\Router;

spl_autoload_register(function (string $className) {
    require_once __DIR__ . '/../' . str_replace('\\', '/', $className) . '.php';
});

$router = new Router();
$router->runController();
