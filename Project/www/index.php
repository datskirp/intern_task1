<?php

define("ROOT", dirname(__DIR__));



/*
spl_autoload_register(function (string $className) {
    require_once __DIR__ . '/../' . str_replace('\\', '/', $className) . '.php';
});
*/

require __DIR__ . '/../vendor/autoload.php';

$container = require ROOT . '/App/Container.php';

/** @var $router \App\Router*/
$router = $container->get(\App\Router::class);
$callback = $router->getCallback();
var_dump($callback);
$container->call([$callback[0], $callback[1]], $callback[2]);

