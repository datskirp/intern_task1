<?php

namespace App\Validator;

class ApiValidator extends Base
{
    private array $fields;
    protected int $id;
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

    public function validate(array $data) : array|false
    {
        $sanitization_rules = [];
        $validation_rules  = [];
        $fields = $this->fields;
        $messages = $this->messages;
        $this->id = $data['id'];

        foreach ($fields as $field=>$rules) {
            if (strpos($rules, '|')) {
                [$sanitization_rules[$field], $validation_rules[$field] ] =  explode('|', $rules, 2);
            } else {
                $sanitization_rules[$field] = $rules;
            }
        }

        $inputs = $this->sanitize($data, $sanitization_rules, self::FILTERS);
        $this->validateData($inputs, $validation_rules, $messages);
        return $this->errors ? false : $inputs;
    }
}
