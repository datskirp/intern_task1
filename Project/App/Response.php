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

    public function send(bool $status, array $alerts, int $id, string $redirectUri): string
    {
        header('Content-Type: application/json; charset=utf-8');

        return $status ?
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
}
