<?php
return [
    '~^$~' => [App\Controllers\UserController::class, 'viewAll'],
    '~^add$~' => [App\Controllers\UserController::class, 'addForm'],
    '~^user/add$~' => [App\Controllers\UserController::class, 'add'],
    '~^user/edit/(\d{10})$~' => [App\Controllers\UserController::class, 'editForm'],
    '~^user/delete/(\d{10})$~' => [App\Controllers\UserController::class, 'delete'],
    '~^user/edit$~' => [App\Controllers\UserController::class, 'edit']
];