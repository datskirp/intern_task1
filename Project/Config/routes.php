<?php
return [
    '/' => [App\Controllers\UserController::class, 'view'],
    '/add' => [App\Controllers\UserController::class, 'addForm'],
    '/edit' => [App\Controllers\UserController::class, 'edit'],
    '/user/delete' => [App\Controllers\UserController::class, 'delete']
];