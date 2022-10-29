<?php

namespace App\Validator;

class UserValidator extends Base
{
    private array $fields;
    private array $messages;

    public function __construct()
    {
        $this->fields = [
            'firstname' => 'string | alpha | between: 1, 120',
            'lastname' => 'string | alpha | between: 1, 120',
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
        return $this->filter($data, $this->fields, $this->messages);
    }
}
