<?php

namespace App;

class Session
{
    public const FLASH = 'FLASH_MESSAGES';

    public function __construct()
    {
        session_start();
    }

    public static function stop(): void
    {
        session_unset();
        unset($_SESSION);
    }

    public static function startSession(): void
    {
        session_start();
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
