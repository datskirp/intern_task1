<?php
namespace App;

use App\Models\User;

class Validator
{
    private static $instance;
    public static array $errorMessages = [];
    private static bool $isValid;

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function validate(array $user)
    {
        self::email($user['email'], $user['id']);
        self::name($user['name']);
        self::$errorMessages ? self::$isValid = false : self::$isValid = true;
    }

    public static function isValid(): bool
    {
        return self::$isValid;
    }

    private static function email(string $email, string $id): void
    {
        $db = Db::getInstance();
        $emailExists = $db->checkEmailExistence($email);
        $getExistingEmail = $db->getEmailById((int)$id);
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            self::$errorMessages['email'] = 'E-mail is not valid';
        if($getExistingEmail) {
            if ($emailExists && $getExistingEmail['email'] != $email)
                self::$errorMessages['emalExists'] = true;
        } elseif ($emailExists) {
            self::$errorMessages['emalExists'] = true;
        }
    }

    private static function name(string $name): void
    {
        if(!preg_match("/\b([A-ZÀ-ÿ][-,a-z. ']+[ ]*)+/", $name))
            self::$errorMessages['name'] = "Name is not valid";
    }

    private static function idExists(string $id): void
    {
        $user = new User();
        if(!$user->show((int)$id))
            self::$errorMessages['Id'] = "Id was not found";
    }

    public static function deleteErrorMessages(): void
    {
        self::$errorMessages = [];
    }
}