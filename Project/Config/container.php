<?php
use function DI\create;
use function DI\get;

return [
    \App\Router::class => DI\autowire()->constructorParameter('routes', require ROOT . '/Config/routes.php'),
    \App\Models\User\Base::class => DI\autowire()->constructor(\App\Db::class, \App\Validator\UserValidator::class),
];
