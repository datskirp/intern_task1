<?php

namespace App;

class Response
{
    public function statusCode(int $code): void
    {
        http_response_code($code);
    }

    public function redirect($url): void
    {
        header("Location: $url");
    }

    public function send(bool $status, array $alerts, int $id, string $redirectUri): void
    {
        header('Content-Type: application/json; charset=utf-8');
        echo $status ?
            json_encode([
                'status' => 'true',
                'redirect_uri' => $redirectUri,
                'id' => $id,
            ]) :
            json_encode([
                'status' => 'false',
                'redirect_uri' => 'null',
                'id' => $id,
                'alerts' => $alerts,
            ]);
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
