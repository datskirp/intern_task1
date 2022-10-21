<?php

namespace App\Validator;

use App\Models\User\User;

abstract class Base
{
    protected array $errors = [];

    abstract public function validate(array $inputFields): bool;

    protected function required(string $field, string $value, bool $rule): bool
    {
        if (empty($value) && $rule === true) {
            $this->errors[$field] = 'This field is required';

            return true;
        }

        return false;
    }

    protected function email(string $field, string $value, bool $rule): bool
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = 'This field must be a valid email address';
            if ($rule) {
                return true;
            }
        }

        return false;
    }

    protected function unique(string $field, string $value, bool $rule): bool
    {
        if ($rule && User::checkEmailExistence($value) &&
            (User::getEmailById($this->id)[$field] ?? '') !== $value) {
            $this->errors[$field] = 'Entered email already exists!';

            return true;
        }

        return false;
    }

    protected function max(string $field, string $value, int $rule): bool
    {
        if (strlen($value) > $rule) {
            $this->errors[$field] = 'The value you entered is too long';

            return true;
        }

        return false;
    }

    protected function min(string $field, string $value, int $rule): bool
    {
        if (strlen($value) < $rule) {
            $this->errors[$field] = 'The value you entered is too short';

            return true;
        }

        return false;
    }

    protected function enum(string $field, string $value, array $rule): bool
    {
        if (!in_array($value, $rule)) {
            $this->errors[$field] = 'Only '. implode(', ', $rule) . ' values are allowed';

            return true;
        }

        return false;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
