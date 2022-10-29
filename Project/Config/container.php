<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

return [
    App\Router::class => DI\autowire()->constructorParameter('routes', require ROOT . '/Config/routes.php'),
    App\Models\User\User::class => DI\autowire()
        ->method('setValidator', DI\get(App\Validator\UserValidator::class)),
    App\Controllers\Api\v1\ApiController::class => DI\autowire()
        ->method('setApiValidator', DI\get(App\Validator\ApiValidator::class)),
    App\Controllers\Upload\UploadController::class => DI\autowire()
        ->method('setUploadValidator', DI\get(App\Validator\UploadValidator::class)),
    App\Controllers\Auth\AuthController::class => DI\autowire()
        ->method('setBlockByIp', DI\get(App\Services\BlockByIp::class))
        ->method('setLogin', DI\get(App\Services\Login::class)),
    Environment::class => function () {
        $loader = new FilesystemLoader(ROOT . '/Views');
        return new Environment($loader);
    },
];
