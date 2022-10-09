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

    public function send(bool $status, array $alerts, string $id, string $redirectUri): void
    {
        header('Content-Type: application/json; charset=utf-8');
        echo $status ?
            json_encode([
                'status' => 'true',
                'redirect_url' => $redirectUri,
                'id' => $id,
            ]) :
            json_encode([
                    'status' => 'false',
                    'redirect_url' => 'null',
                    'id' => $id,
                ] + $alerts);
    }
}