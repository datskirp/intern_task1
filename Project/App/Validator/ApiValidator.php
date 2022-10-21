<?php

namespace App\Validator;

class ApiValidator extends Base
{
    private array $rules;
    protected int $id;

    public function __construct()
    {
        $this->rules = [
            'email' => ['required' => true, 'max' => 255, 'email' => true, 'unique' => true],
            'name' => ['required' => true, 'max' => 120, 'min' => 2],
            'gender' => ['required' => true, 'enum' => ['male', 'female']],
            'status' => ['required' => true, 'enum' => ['active', 'inactive']],
            'id' => [],
        ];
    }
    public function validate(array $inputFields): bool
    {
        if (!empty(array_diff_key($this->rules, $inputFields))) {
            $this->errors['error'] = "Wrong input field names in a request body. Input fields must be: 'id' (optional: will get overwritten), 'email', 'name', 'gender', 'status'.";

            return false;
        }
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