<?php
use function DI\create;
use App\Controllers\BaseController;
use App\Controllers\UserController;

return [
    \App\Router::class => DI\autowire()->constructorParameter('routes', require ROOT . '/Config/routes.php'),
    BaseController::class => create(UserController::class),
];
