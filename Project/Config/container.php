<?php
use function DI\create;
use App\Controllers\BaseController;
use App\Controllers\UserController;

return [
    BaseController::class => create(UserController::class),
];
