<?php

namespace App\Validator;

use App\Db;

class Validator extends Base
{
    private bool $isValid;

    public function validate(array $inputFields, array $rules): void
    {
        foreach ($inputFields as $field => $value) {
            if (array_key_exists($field, $rules)) {
                foreach ($rules[$field] as $constraint) {
                    if(!$this->alert->getAlerts() || !array_key_exists($field, $this->alert->getAlerts())) {
                        if ($constraint === 'required' && !$value) {
                            $this->alert->setAlerts([$field => 'This field is required']);
                            break;
                        }

                        if ($constraint === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                            $this->alert->setAlerts([$field => 'This field must be a valid email address']);
                            break;
                        }
                        if ($constraint === 'unique') {
                            $db = Db::getInstance();
                            if ($db->checkEmailExistence($value) &&
                                    ($db->getEmailById($inputFields['id'])[$field] ?? '') !== $value) {
                                $this->alert->setAlerts([$field => 'Entered email already exists!']);
                            }
                        }
                        if ($constraint === 'name' &&
                            !preg_match("/^\p{L}+(['-]\p{L}+)*\.?(\s\p{L}+(['-]\p{L}+)*\.?)+$/", $value)) {
                            $this->alert->setAlerts([$field => 'Enter a valid name']);
                            break;
                        }
                    }
                }
            }
        }
        empty($this->alert->getAlerts()) ? $this->isValid = true : $this->isValid = false;

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