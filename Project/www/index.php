<?php

use App\Router;

/*
spl_autoload_register(function (string $className) {
    require_once __DIR__ . '/../' . str_replace('\\', '/', $className) . '.php';
});
*/

require __DIR__ . '/../vendor/autoload.php';

$router = new Router();
$router->run();
