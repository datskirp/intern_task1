<?php
return [
    '~^/main/add$~' => [\Controllers\Main::class, 'add'],
    '~^/$~' => [\Controllers\Main::class, 'main']
];