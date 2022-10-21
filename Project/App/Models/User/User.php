<?php

namespace App\Models\User;

use App\Db;
use App\Validator\UserValidator;

class User extends Base
{
    private string $email;
    private string $name;
    private string $gender;
    private string $status;

    protected static function getTableName(): string
    {
        return 'users';
    }

    public function getEmail(): string
    {
        return $this->email;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getGender(): string
    {
        return $this->gender;
    }
    public function getStatus(): string
    {
        return $this->status;
    }

    public function store(array $input): bool
    {
        if ($this->validator->validateUser($input)) {
            var_dump($this->insert($input));

        }
    }
}
