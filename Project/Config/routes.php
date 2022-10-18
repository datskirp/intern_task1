<?php

return ['get' => [
    '/' => [\App\Upload::class, 'index'],
    ],
    'post' => [
        '/' => [\App\Upload::class, 'upload'],
    ],
];
