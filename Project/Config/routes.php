<?php
return [
    '~^/main/add$~' => [\Controllers\MainController::class, 'add'],
    '~^/$~' => [\Controllers\MainController::class, 'main']
];