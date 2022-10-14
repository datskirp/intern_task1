<?php

namespace App\Validator;

use App\Db;

class Validator extends Base
{
    private bool $isValid;
    private int $id;

    public function validate(array $inputFields, array $rules): void
    {
        $this->alert->resetAlerts();
        $this->id = $inputFields['id'];
        foreach ($inputFields as $field => $value) {
            if (array_key_exists($field, $rules)) {
                foreach ($rules[$field] as $constraint => $rule) {
                    if ($this->$constraint($field, $value, $rule)) {
                        break;
                    }
                }
            } else {
                $this->alert->setAlerts($field, "This field is not allowed!");
            }
        }
        empty($this->alert->getAlerts()) ? $this->isValid = true : $this->isValid = false;
    }

    private function required(string $field, string $value, string $rule): bool
    {
        if (empty($value) && $rule === 'yes') {
            $this->alert->setAlerts($field, 'This field is required');

            return true;
        }

        return false;
    }


    private function valid(string $field, string $value, string $rule): bool
    {
        return $this->$rule($field, $value);
    }

    private function email(string $field, string $value): bool
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->alert->setAlerts($field, 'This field must be a valid email address');

            return true;
        }

        return false;
    }

    private function unique(string $field, string $value, string $rule): bool
    {
        $db = Db::getInstance();
        if ($rule === 'yes' && $db->checkEmailExistence($value) &&
            ($db->getEmailById($this->id)[$field] ?? '') !== $value) {
            $this->alert->setAlerts($field, 'Entered email already exists!');

            return true;
        }

        return false;
    }

    private function name(string $field, string $value): bool
    {
        if (!preg_match("/^\p{L}+(['-]\p{L}+)*\.?(\s\p{L}+(['-]\p{L}+)*\.?)+$/", $value)) {
            $this->alert->setAlerts($field, 'Enter a valid name');

            return true;
        }

        return false;
    }

    private function maxsize(string $field, string $value, int $rule): bool
    {
        if (strlen($value) > $rule) {
            $this->alert->setAlerts($field, 'The value you entered is too long');

            return true;
        }

        return false;
    }

    private function enum(string $field, string $value, array $rule): bool
    {
        if (!in_array($value, $rule)) {
            $this->alert->setAlerts($field, 'Only '. implode(', ', $rule) . ' values are allowed');

            return true;
        }

        return false;
    }

    public function userValidatorRules()
    {
        return include __DIR__ . '/../../' . '/Config/userValidatorRules.php';
    }

    public function isValid(): bool
    {
        return $this->isValid;
    }

    public function getAlerts(): array
    {
        return $this->alert->getAlerts();
    }
}
