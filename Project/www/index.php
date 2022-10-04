<?php

use App\Router;
use App\Response;

spl_autoload_register(function (string $className) {
    require_once __DIR__ . '/../' . str_replace('\\', '/', $className) . '.php';
});


$router = new Router();
$router->run();

