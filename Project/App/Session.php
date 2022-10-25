<?php

namespace App;

class Session
{
    const FLASH = 'FLASH_MESSAGES';

    const FLASH_ERROR = 'error';
    const FLASH_WARNING = 'warning';
    const FLASH_INFO = 'info';
    const FLASH_SUCCESS = 'success';

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

    public static function createFlash(string $name, string $message, string $type): void
    {

        if (isset($_SESSION[self::FLASH][$name])) {
            unset($_SESSION[self::FLASH][$name]);
        }

        $_SESSION[self::FLASH][$name] = ['message' => $message, 'type' => $type];
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
