<?php

return [
    'email' => ['required' => 'yes', 'maxsize' => 255, 'valid' => 'email', 'unique' => 'yes'],
    'name' => ['required' => 'yes', 'maxsize' => 255, 'valid' => 'name'],
    'gender' => ['enum' => ['male', 'female']],
    'status' => ['enum' => ['active', 'inactive']],
];
