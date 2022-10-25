<?php

namespace App\Validator;

use App\Models\User\User;
use App\Controllers\Upload\UploadController;

abstract class Base
{
    public const FILTERS = [
        'string' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'string[]' => [
            'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'flags' => FILTER_REQUIRE_ARRAY,
        ],
        'email' => FILTER_SANITIZE_EMAIL,
        'int' => [
            'filter' => FILTER_SANITIZE_NUMBER_INT,
            'flags' => FILTER_REQUIRE_SCALAR,
        ],
    ];
    public const DEFAULT_VALIDATION_ERRORS = [
        'required' => 'Please enter the %s',
        'email' => 'The %s is not a valid email address',
        'min' => 'The %s must have at least %s characters',
        'max' => 'The %s must have at most %s characters',
        'between' => 'This field must have between %2$d and %3$d characters',
        'same' => 'The %s must match with %s',
        'alphanumeric' => 'The %s should have only letters and numbers',
        'secure' => 'The %s must have between 7 and 64 characters and contain at least one number, one upper case letter, one lower case letter and one special character',
        'unique' => 'The %s already exists',
        'enum' => 'The values of %s field should be %s or %s',
        'image' => 'The file must be image or text',
        'txt' => 'The file must be image or text',
        'enoughLocalStorage' => "There's not enough free space on the disk!",
        'maxSize' => 'The file %s must not exceed %s bytes',
        'alpha' => 'This field must contain letters only',
    ];
    protected array $errors = [];
    protected bool $fileTypeChecked = false;

    abstract public function validate(array $data): mixed;

    protected function filter(array $data, array $fields, array $messages): array|false
    {
        $sanitization_rules = [];
        $validation_rules = [];

        foreach ($fields as $field => $rules) {
            if (strpos($rules, '|')) {
                [$sanitization_rules[$field], $validation_rules[$field] ] = explode('|', $rules, 2);
            } else {
                $sanitization_rules[$field] = $rules;
            }
        }

        $inputs = $this->sanitize($data, $sanitization_rules, self::FILTERS);
        $this->validateData($inputs, $validation_rules, $messages);

        return $this->errors ? false : $inputs;
    }

    protected function validateData(array $data, array $fields, array $messages = []): void
    {
        $split = fn ($str, $separator) => array_map('trim', explode($separator, $str));
        $rule_messages = array_filter($messages, fn ($message) => is_string($message));
        $validation_errors = array_merge(self::DEFAULT_VALIDATION_ERRORS, $rule_messages);
        foreach ($fields as $field => $option) {
            $rules = $split($option, '|');
            foreach ($rules as $rule) {
                $params = [];
                if (strpos($rule, ':')) {
                    [$rule_name, $param_str] = $split($rule, ':');
                    $params = $split($param_str, ',');
                } else {
                    $rule_name = trim($rule);
                }
                $fn = 'is_' . $rule_name;
                if (is_callable([$this, $fn])) {
                    $pass = $this->$fn($data, $field, ...$params);
                    if (!$pass) {
                        $this->errors[$field] = sprintf(
                            $messages[$field][$rule_name] ?? $validation_errors[$rule_name],
                            $field,
                            ...$params
                        );
                    }
                }
            }
        }
    }

    private function arrayTrim(array $items): array
    {
        return array_map(function ($item) {
            if (is_string($item)) {
                return trim($item);
            } elseif (is_array($item)) {
                return $this->arrayTrim($item);
            } else {
                return $item;
            }
        }, $items);
    }

    protected function sanitize(array $inputs, array $fields, array $filters, bool $trim = true): array
    {
        $options = array_map(fn ($field) => $filters[trim($field)], $fields);
        $data = filter_var_array($inputs, $options);

        return $trim ? $this->arrayTrim($data) : $data;
    }

    private function is_image(array $data, string $field): bool
    {
        if ($this->fileTypeChecked) {
            return true;
        }
        $finfo = finfo_open(FILEINFO_MIME);
        $mimetype = finfo_file($finfo, $data['tmp_name']);
        if (str_contains($mimetype, 'image')) {
            unset($this->errors[$field]);
            $this->fileTypeChecked = true;

            return true;
        }

        return false;
    }

    private function is_txt(array $data, string $field): bool
    {
        if ($this->fileTypeChecked) {
            return true;
        }
        if (pathinfo($data['name'], PATHINFO_EXTENSION) === 'txt') {
            unset($this->errors[$field]);
            $this->fileTypeChecked = true;

            return true;
        }

        return false;
    }

    private function is_enoughLocalStorage(array $data, string $field): bool
    {
        if (diskfreespace(ROOT . '/www') - $data['size'] > 0) {
            return true;
        }

        return false;
    }

    private function is_maxSize(array $data, string $field): bool
    {
        return $data['size'] < UploadController::MAX_FILE_SIZE;
    }

    private function is_required(array $data, string $field): bool
    {
        return isset($data[$field]) && trim($data[$field]) !== '';
    }

    private function is_email(array $data, string $field): bool
    {
        if (empty($data[$field])) {
            return true;
        }

        return filter_var($data[$field], FILTER_VALIDATE_EMAIL);
    }

    private function is_min(array $data, string $field, int $min): bool
    {
        if (!isset($data[$field])) {
            return true;
        }

        return strlen($data[$field]) >= $min;
    }

    private function is_alpha(array $data, string $field): bool
    {
        return ctype_alpha($data[$field]);
    }

    private function is_max(array $data, string $field, int $max): bool
    {
        if (!isset($data[$field])) {
            return true;
        }

        return strlen($data[$field]) <= $max;
    }

    private function is_between(array $data, string $field, int $min, int $max): bool
    {
        if (!isset($data[$field])) {
            return true;
        }

        $len = strlen($data[$field]);

        return $len >= $min && $len <= $max;
    }

    private function is_same(array $data, string $field, string $other): bool
    {
        if (isset($data[$field], $data[$other])) {
            return $data[$field] === $data[$other];
        }

        if (!isset($data[$field]) && !isset($data[$other])) {
            return true;
        }

        return false;
    }

    private function is_secure(array $data, string $field): bool
    {
        if (!isset($data[$field])) {
            return false;
        }

        $pattern = "#.*^(?=.{7,64})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#";

        return preg_match($pattern, $data[$field]);
    }

    private function is_unique(array $data, string $field): bool
    {
        if (!isset($data[$field])) {
            return true;
        }
        if (User::isRecord($field, $data[$field])) {
            return false;
        }

        return true;
    }

    private function is_enum(array $data, string $field, $enumParam1, $enumParam2)
    {
        $checkAgainst = [$enumParam1, $enumParam2];

        return in_array($data[$field], $checkAgainst);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
