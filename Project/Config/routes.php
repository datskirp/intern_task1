<?php

return ['get' => [
    '/' => [\App\Controllers\UserController::class, 'index'],
    '/user/{id:\d+}' => [\App\Controllers\UserController::class, 'show'],
    '/user/create' => [\App\Controllers\UserController::class, 'create'],
    '/user/{id:\d+}/edit' => [\App\Controllers\UserController::class, 'edit'],
],
    'post' => [
        '/user' => [\App\Controllers\UserController::class, 'store'],
    ],
    'put' => [
        '/user/{id:\d+}' => [\App\Controllers\UserController::class, 'update'],
    ],
    'delete' => [
        '/user/{id:\d+}' => [\App\Controllers\UserController::class, 'delete'],
    ],
];
