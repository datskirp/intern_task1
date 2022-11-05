<?php

return ['get' => [
    '/' => [App\Controllers\Product\ProductController::class, 'index',
        [App\Services\Middleware\isGuest::class, App\Services\Middleware\checkCart::class]],
    '/card/{id:\d+}' => [App\Controllers\Product\ProductController::class, 'card'],
    '/user/{id:\d+}' => [App\Controllers\User\UserController::class, 'show'],
    '/user/create' => [App\Controllers\User\UserController::class, 'create'],
    '/user/{id:\d+}/edit' => [App\Controllers\User\UserController::class, 'edit'],
    '/api/v1/user/{id:\d+}' => [App\Controllers\Api\v1\ApiController::class, 'show'],
    '/api/v1/users' => [App\Controllers\Api\v1\ApiController::class, 'showAll'],
    '/upload' => [App\Controllers\Upload\UploadController::class, 'index', [App\Services\Middleware\Authorization::class]],
    '/register' => [App\Controllers\Auth\AuthController::class, 'register'],
    '/login' => [App\Controllers\Auth\AuthController::class, 'login'],
    '/logout' => [App\Controllers\Auth\AuthController::class, 'logout'],
    '/cart' => [App\Controllers\Cart\CartController::class, 'index'],
],
    'post' => [
        '/user' => [App\Controllers\User\UserController::class, 'store'],
        '/api/v1/users' => [App\Controllers\Api\v1\ApiController::class, 'store'],
        '/upload' => [App\Controllers\Upload\UploadController::class, 'upload'],
        '/register' => [App\Controllers\Auth\AuthController::class, 'signUp'],
        '/authenticate' => [App\Controllers\Auth\AuthController::class, 'authenticate'],
        '/cart/{id:\d+}' => [App\Controllers\Cart\CartController::class, 'addProduct'],

    ],
    'put' => [
        '/user/{id:\d+}' => [App\Controllers\User\UserController::class, 'update'],
        '/api/v1/user/{id:\d+}' => [App\Controllers\Api\v1\ApiController::class, 'update'],
    ],
    'delete' => [
        '/user/{id:\d+}' => [App\Controllers\User\UserController::class, 'delete'],
        '/api/v1/user/{id:\d+}' => [App\Controllers\Api\v1\ApiController::class, 'delete'],
        '/cart/{id:\d+}' => [App\Controllers\Cart\CartController::class, 'deleteProduct'],
    ],
];
