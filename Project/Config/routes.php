<?php

return ['get' => [
    '/' => [\App\Controllers\User\UserController::class, 'index'],
    '/user/{id:\d+}' => [\App\Controllers\User\UserController::class, 'show'],
    '/user/create' => [\App\Controllers\User\UserController::class, 'create'],
    '/user/{id:\d+}/edit' => [\App\Controllers\User\UserController::class, 'edit'],
],
    'post' => [
        '/user' => [\App\Controllers\User\UserController::class, 'store'],
    ],
    'put' => [
        '/user/{id:\d+}' => [\App\Controllers\User\UserController::class, 'update'],
    ],
    'delete' => [
        '/user/{id:\d+}' => [\App\Controllers\User\UserController::class, 'delete'],
    ],
];
