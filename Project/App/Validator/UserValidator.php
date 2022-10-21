<?php

namespace App\Validator;

class UserValidator extends Base
{
    private array $rules;
    protected int $id;

    public function __construct()
    {
        $this->rules = [
            'email' => ['required' => true, 'max' => 255, 'email' => true, 'unique' => true],
            'name' => ['required' => true, 'max' => 120, 'min' => 2],
        ];
    }

    public function validate(array $inputFields): bool
    {
        $this->errors = [];
        $this->id = $inputFields['id'];
        foreach ($inputFields as $field => $value) {
            if (array_key_exists($field, $this->rules)) {
                foreach ($this->rules[$field] as $constraint => $rule) {
                    if ($this->$constraint($field, $value, $rule)) {
                        break;
                    }
                }
            }
        }

        return empty($this->errors);
    }
}
