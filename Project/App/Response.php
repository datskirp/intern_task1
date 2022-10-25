<?php

namespace App;

class Response
{
    private const HEADER_CONTENT = 'Content-Type: application/json; charset=utf-8';
    private array $responseBody;

    private function setDefaultHeader(): void
    {
        header(self::HEADER_CONTENT);
    }

    public function statusCode(int $code): void
    {
        http_response_code($code);
    }

    public function redirect($url): void
    {
        header("Location: $url");
    }

    public function send(bool $status, string $redirectUri, array $alerts = [], int $id = null): string
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

    public function dbIsEmpty(): string
    {
        $this->responseBody['status'] = false;
        $this->responseBody['msg'] = 'There are no users in the database!';

        return json_encode($this->responseBody);
    }

    public function sendError(int $statusCode, int $id = null): string
    {
        $this->statusCode($statusCode);
        $this->setDefaultHeader();
        switch ($statusCode) {
            case 400:
                return json_encode(['status' => 'There is no such user with id: ' . $id . '!']);
            case 404:
                return json_encode(['status' => 'The endpoint is not found']);
        }
    }

    public function sendApi($data, $id = null, string $html = ''): string
    {
        $this->responseBody['status'] = true;
        $this->setDefaultHeader();
        if (!is_null($id)) {
            $this->responseBody['id'] = $id;
        }
        if (!empty($data)) {
            $this->responseBody['data'] = $data;
        }
        if (!empty($html)) {
            $this->responseBody['html'] = $html;
        }

        return json_encode($this->responseBody);
    }

    public function sendNotValid(int $id, array $alerts): string
    {
        $this->responseBody['status'] = false;
        $this->responseBody['id'] = $id;
        $this->responseBody['alerts'] = $alerts;
        $this->statusCode(400);
        $this->setDefaultHeader();

        return json_encode($this->responseBody);
    }
}
