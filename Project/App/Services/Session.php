<?php

namespace App\Services;

class Session
{
    public const FLASH = 'FLASH_MESSAGES';

    public function __construct()
    {
        session_start();
    }

    public static function resetId()
    {
        session_regenerate_id();
    }

    public static function stop(): void
    {
        session_unset();
        session_destroy();
        unset($_SESSION);
    }

    public static function startSession(): void
    {
        session_start();
    }

    public function setLogin($email, $id): void
    {
        $_SESSION['email'] = $email;
        $_SESSION['id'] = $id;
    }

    public function getId(): int|false
    {
        return isset($_SESSION['id']) ?? false;
    }

    public static function createFlash(string $name, string $message): void
    {
        if (isset($_SESSION[self::FLASH][$name])) {
            unset($_SESSION[self::FLASH][$name]);
        }

        $_SESSION[self::FLASH][$name] = ['message' => $message];
    }

    public static function getFlash(string $name): ?array
    {
        if (!isset($_SESSION[self::FLASH][$name])) {
            return null;
        }
        $flash = $_SESSION[self::FLASH][$name];

        unset($_SESSION[self::FLASH][$name]);

        return $flash;
    }

    public function setSessionMsg(string $action, int $id): void
    {
        if (!isset($_SESSION)) {
            $this->startSession();
        }
        $_SESSION['action'] = $action;
        $_SESSION['id'] = $id;
    }
}
