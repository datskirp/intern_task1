<?php

namespace App;

class Session
{
    public function __construct()
    {
        session_start();
    }

    public function set($key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function stop(): void
    {
        session_unset();
        unset($_SESSION);
    }
}
