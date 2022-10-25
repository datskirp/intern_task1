<?php

namespace App\Validator;

class UserValidator extends Base
{
    private array $fields;
    protected int $id;
    private array $messages = [];

    public function __construct()
    {
        $this->fields = [
            'first_name' => 'string | alpha | between: 1, 120',
            'last_name' => 'string | alpha | between: 1, 120',
            'email' => 'email | required | email | unique | max: 320',
            'confirm_email' => 'email | required | same: email',
            'password' => 'string | required | secure',
            'confirm_password' => 'string | required | same: password',
        ];
        $this->messages = [
            'confirm_password' => [
                'required' => 'Please confirm the password',
                'same' => "The passwords' fields do not match"
            ],
            'confirm_email' => [
                'required' => 'Please confirm the email',
                'same' => 'The email fields do not match'
            ]
        ];

    }

    public function validate(array $data) : array|false
    {
        $sanitization_rules = [];
        $validation_rules  = [];
        $fields = $this->fields;
        $messages = $this->messages;

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
