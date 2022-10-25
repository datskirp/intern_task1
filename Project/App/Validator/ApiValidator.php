<?php

namespace App\Validator;

class ApiValidator extends Base
{
    private array $fields;
    private array $messages = [];

    public function __construct()
    {
        $this->fields = [
            'id' => 'int | required',
            'name' => 'string | required | between: 2, 120',
            'email' => 'email | required | email | unique | max: 320',
            'gender' => 'string | enum: male, female',
            'status' => 'string | enum: active, inactive',
        ];
    }

    public function validate(array $data): array|false
    {
        return $this->filter($data, $this->fields, $this->messages);
    }
}
