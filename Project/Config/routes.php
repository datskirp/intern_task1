<?php
return [
    '/' => [App\Controllers\UserController::class, 'viewAll'],
    '/add' => [App\Controllers\UserController::class, 'addForm'],
    '/user/add' => [App\Controllers\UserController::class, 'add'],
    '/user/edit' => [App\Controllers\UserController::class, 'editForm'],
    '/user/delete' => [App\Controllers\UserController::class, 'delete'],
    '/edit' => [App\Controllers\UserController::class, 'edit']
];