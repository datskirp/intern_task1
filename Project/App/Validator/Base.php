<?php

namespace App\Validator;

use App\Models\User\User;

abstract class Base
{
    protected array $errors;
    protected bool $isValid;

    private function required(string $field, string $value, bool $rule): bool
    {
        if (empty($value) && $rule === true) {
            $this->errors[$field] = 'This field is required';

            return true;
        }

        return false;
    }

    private function email(string $field, string $value, bool $rule): bool
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = 'This field must be a valid email address';
            if($rule) {
                return true;
            }
        }

        return false;
    }

    private function unique(string $field, string $value, bool $rule): bool
    {
        if ($rule && static::checkEmailExistence($value) &&
            (static::getEmailById($this->id)[$field] ?? '') !== $value) {
            $this->errors[$field] = 'Entered email already exists!';

            return true;
        }

        return false;
    }

    private function max(string $field, string $value, int $rule): bool
    {
        if (strlen($value) > $rule) {
            $this->errors[$field] = 'The value you entered is too long';

            return true;
        }

        return false;
    }

    private function min(string $field, string $value, int $rule): bool
    {
        if (strlen($value) < $rule) {
            $this->errors[$field] = 'The value you entered is too long';

            return true;
        }

        return false;
    }

    public function isValid(): bool
    {
        return $this->isValid;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
