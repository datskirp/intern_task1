<?php

namespace App;

class Session
{
    public function __construct()
    {
        //session_start();
    }

    public function stop(): void
    {
        session_unset();
        unset($_SESSION);
    }

    public function startSession(): void
    {
        session_start();
    }

    public function stopSession(): void
    {
        session_unset();
        unset($_SESSION);
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
