<?php

namespace App\Models\User;

use App\Models\Base;
use App\Validator\UserValidator;

class User extends Base
{
    private int $id;
    private string $email;
    private string $firstname;
    private string $lastname;
    private string $password;
    public $validator;

    protected static function getTableName(): string
    {
        return 'users';
    }

    public function setValidator(UserValidator $validator)
    {
        $this->validator = $validator;
    }

    public function validate($data): array|false
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
    public function getFirstname(): string
    {
        return $this->firstname;
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
