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
    private string $created_date;
    public $validator;

    protected static function getTableName(): string
    {
        return 'users';
    }

    public function setValidator(UserValidator $validator)
    {
        $this->validator = $validator;
    }

    public function validateSignUp($data): array|false
    {
        $result =  $this->validator->validate($data);
        if($result) {
            foreach ($result as $key => $value) {
                if (str_contains($key, 'confirm')) {
                    unset($result[$key]);
                }
                if ($key === 'password') {
                    $result[$key] = password_hash($value, PASSWORD_DEFAULT);
                }
            }
            return $result;
        }
        return false;
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
    public function getLastName(): string
    {
        return $this->lastname;
    }
    public function getPassword(): string
    {
        return $this->password;
    }
    public function getDate(): string
    {
        return $this->created_date;
    }

}
