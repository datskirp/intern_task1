<?php

use App\Router;

define('ROOT', dirname(__DIR__));
spl_autoload_register(function (string $className) {
    require_once ROOT . '/' . str_replace('\\', '/', $className) . '.php';
});

$router = new Router();
$router->run();

