<?php

use App\Router;
use App\Request;
use App\Validator\Validator;
use App\View;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/*
spl_autoload_register(function (string $className) {
    require_once __DIR__ . '/../' . str_replace('\\', '/', $className) . '.php';
});
*/
require __DIR__ . '/../vendor/autoload.php';

const UPLOAD = 'upload';
const MAX_FILE_SIZE = 5000000;

$loader = new FilesystemLoader(__DIR__ . '/../Views');
$twig = new Environment($loader);
$view = new View($twig, MAX_FILE_SIZE);
$validator = new Validator();

$request = new Request();
$router = new Router($request, include_once __DIR__ . '/../Config/routes.php');
$callback = $router->getCallback();
if ($callback) {
    $validatorRules = require_once __DIR__ . '/../Config/validatorRules.php';
    $upload = new $callback[0]($validator, $view, $validatorRules);
    echo(call_user_func([$upload, $callback[1]], $request::getFile(), UPLOAD));
} else {
    echo $view->render404('404.html.twig');
}
