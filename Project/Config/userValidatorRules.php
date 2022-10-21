<?php

return [
    'email' => ['required' => true, 'maxsize' => 255, 'valid' => 'email', 'unique' => 'yes'],
    'name' => ['required' => true, 'maxsize' => 255, 'valid' => 'name'],
];
