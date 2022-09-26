<?php
return [
    '~^/main/add$~' => [App\Controllers\MainController::class, 'add'],
    '~^/$~' => [App\Controllers\MainController::class, 'main']
];