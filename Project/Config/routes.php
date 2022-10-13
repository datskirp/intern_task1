<?php

return [
    'get' => [
        '/' => [\App\Controllers\UserController::class, 'index'],
        '/api/v1/user/{id:\d+}' => [\App\Controllers\UserController::class, 'show'],
        '/api/v1/users' => [\App\Controllers\UserController::class, 'showAll'],
        '/user/create' => [\App\Controllers\UserController::class, 'create'],
        '/user/{id:\d+}/edit' => [\App\Controllers\UserController::class, 'edit'],
    ],
    'post' => [
        '/api/v1/users' => [\App\Controllers\UserController::class, 'store'],
    ],
    'put' => [
        '/api/v1/user/{id:\d+}' => [\App\Controllers\UserController::class, 'update'],
    ],
    'delete' => [
        '/api/v1/user/{id:\d+}' => [\App\Controllers\UserController::class, 'delete'],
    ],
];
