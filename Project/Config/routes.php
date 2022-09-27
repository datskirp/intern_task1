<?php
return [
    '~^/main/add$~' => [App\Controllers\MainController::class, 'add'],
    '~^/$~' => [App\Controllers\MainController::class, 'main'],
    '~^/user/add-to-database$~' => [App\Controllers\UserController::class, 'add'],
    '~^/main/delete$~' => [App\Controllers\MainController::class, 'delete'],
    '~^/user/delete-from-database$~' => [App\Controllers\UserController::class, 'delete'],
    '~^/main/view$~' => [App\Controllers\UserController::class, 'View']
];