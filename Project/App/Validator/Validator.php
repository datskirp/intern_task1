<?php

namespace App\Validator;

use App\Db;

class Validator extends Base
{
    private static $instance;
    private bool $isValid;

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

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
                            $this->alert->setAlerts([$field => 'This field must be valid email address']);
                            break;
                        }
                        if ($constraint === 'unique') {
                            $db = Db::getInstance();
                            if ($db->checkEmailExistence($value)) {
                                $this->alert->setAlerts([$field => 'Entered e-mail already exists!']);
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

    public function getAlerts()
    {
        return $this->alert->getAlerts();
    }
}