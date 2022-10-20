<?php

use App\Router;

define("ROOT", dirname(__DIR__));

var_dump(ROOT);

/*
spl_autoload_register(function (string $className) {
    require_once __DIR__ . '/../' . str_replace('\\', '/', $className) . '.php';
});
*/

require __DIR__ . '/../vendor/autoload.php';

$container = require ROOT . '/App/Container.php';

$router = new Router();
$router->run();
