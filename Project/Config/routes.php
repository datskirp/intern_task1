<?php

return ['get' => [
    '/' => [App\Controllers\User\UserController::class, 'index'],
    '/user/{id:\d+}' => [App\Controllers\User\UserController::class, 'show'],
    '/user/create' => [App\Controllers\User\UserController::class, 'create'],
    '/user/{id:\d+}/edit' => [App\Controllers\User\UserController::class, 'edit'],
    '/api/v1/user/{id:\d+}' => [App\Controllers\Api\v1\ApiController::class, 'show'],
    '/api/v1/users' => [App\Controllers\Api\v1\ApiController::class, 'showAll'],
    '/upload' => [App\Controllers\Upload\UploadController::class, 'index'],
    '/register' => [App\Controllers\User\UserController::class, 'register'],
],
    'post' => [
        '/user' => [App\Controllers\User\UserController::class, 'store'],
        '/api/v1/users' => [App\Controllers\Api\v1\ApiController::class, 'store'],
        '/upload' => [App\Controllers\Upload\UploadController::class, 'upload'],
    ],
    'put' => [
        '/user/{id:\d+}' => [App\Controllers\User\UserController::class, 'update'],
        '/api/v1/user/{id:\d+}' => [App\Controllers\Api\v1\ApiController::class, 'update'],
    ],
    'delete' => [
        '/user/{id:\d+}' => [App\Controllers\User\UserController::class, 'delete'],
        '/api/v1/user/{id:\d+}' => [App\Controllers\Api\v1\ApiController::class, 'delete'],
    ],
];
