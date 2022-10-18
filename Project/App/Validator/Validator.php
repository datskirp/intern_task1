<?php

namespace App\Validator;

use App\Validator\ValidatorInterface;

use App\Db;

class Validator implements ValidatorInterface
{
    private bool $isValid;
    private array $errorMsg = [];

    public function validate(array $file, array $rules): void
    {
        var_dump($file);
        foreach ($rules as $fileField => $constraintList) {
            foreach ($constraintList as $constraint) {
                if ($this->$constraint($file[$fileField])) {
                    break;
                }
            }
        }
        empty($this->errorMsg) ? $this->isValid = true : $this->isValid = false;
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

    public function userValidatorRules()
    {
        return include __DIR__ . '/../task1/' . '/Config/validatorRules.php';
    }

    public function isValid(): bool
    {
        return $this->isValid;
    }

    public function getErrors(): array
    {
        return $this->errorMsg;
    }
}
