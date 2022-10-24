<?php
use App\App;

define('ROOT', dirname(__DIR__));
/*
spl_autoload_register(function (string $className) {
    require_once __DIR__ . '/../' . str_replace('\\', '/', $className) . '.php';
});
*/

require __DIR__ . '/../vendor/autoload.php';

$app = new App();
$app->run();
