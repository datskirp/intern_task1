<?php

namespace App\Services;

use App\Models\Cart\CartInterface;

class Session
{
    public const FLASH = 'FLASH_MESSAGES';
    public string $errorView = '';

    public function __construct()
    {
        session_start();
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

    public function setLogin(string $email, int $id): void
    {
        $_SESSION['email'] = $email;
        $_SESSION['user_id'] = $id;
    }

    public function getId(): int|false
    {
        return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : false;
    }

    public function getCart(): ?CartInterface
    {
        return $_SESSION['cart'] ?? null;
    }

    public function createCart(CartInterface $cart): void
    {
        $_SESSION['cart'] = $cart;
    }

    public function addItem(string $name, mixed $value): void
    {
        $_SESSION[$name] = $value;
    }

    public function getItem(string $key): mixed
    {
        return $_SESSION[$key];
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
