<?php

namespace App\Models\User;

use App\Db;
use App\Validator\UserValidator;

class User extends Base
{
    private int $id;
    private string $email;
    private string $name;
    private string $gender;
    private string $status;
    public $validator;

    protected static function getTableName(): string
    {
        return 'users';
    }

    public function setValidator(UserValidator $validator)
    {
        $this->validator = $validator;
    }

    public function validate($data): bool
    {
        return $this->validator->validate($data);
    }

    public function getId(): int
    {
        return $this->id;
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

}
