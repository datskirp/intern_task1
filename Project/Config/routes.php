<?php
return [
    '~^/main/add$~' => [App\Controllers\MainController::class, 'add'],
    '~^/$~' => [App\Controllers\MainController::class, 'main'],
    '~^/user/add-to-database$~' => [App\Controllers\UserController::class, 'add'],
    '~^/main/delete$~' => [App\Controllers\MainController::class, 'delete'],
    '~^/user/delete-from-database$~' => [App\Controllers\UserController::class, 'delete'],
    '~^/main/view$~' => [App\Controllers\UserController::class, 'view'],
    '~^/main/edit$~' => [App\Controllers\MainController::class, 'edit'],
    '~^/user/edit-user$~' => [App\Controllers\UserController::class, 'edit'],
    '~^/user/edit-user-id$~' => [App\Controllers\UserController::class, 'getUserInfo']
];