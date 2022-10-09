<?php

namespace App;

class Response
{
    public function statusCode(int $code)
    {
        http_response_code($code);
    }

    public function redirect($url)
    {
        header("Location: $url");
    }

    public function send(bool $status, array $alerts, string $id, string $redirectUri)
    {
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