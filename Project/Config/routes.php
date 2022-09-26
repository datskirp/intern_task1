<?php
return [
    '~^/main/add$~' => [App\Controllers\MainController::class, 'add'],
    '~^/$~' => [App\Controllers\MainController::class, 'main'],
    '~^/user/add-to-database$~' => [App\Controllers\UserController::class, 'add']
];