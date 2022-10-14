<?php

return [
    'email' => ['required' => 'yes', 'maxsize' => 255, 'valid' => 'email', 'unique' => 'yes'],
    'name' => ['required' => 'yes', 'maxsize' => 255, 'valid' => 'name'],
    'gender' => ['required' => 'yes', 'enum' => ['male', 'female']],
    'status' => ['required' => 'yes', 'enum' => ['active', 'inactive']],
    'id' => [],
];
