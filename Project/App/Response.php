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

    private function statusCode(int $code): void
    {
        http_response_code($code);
    }

    public function redirect($url): void
    {
        header("Location: $url");
    }

    public function dbIdEmpty(): void
    {
        $this->responseBody['status'] = false;
        $this->responseBody['msg'] = 'There are no users in the database!';
        echo json_encode($this->responseBody);
    }

    public function send404(): void
    {
        $this->statusCode(404);
        $this->setDefaultHeader();
        //echo json_encode(['msg' => 'There is no such user!']);
    }

    public function send400(string $id): void
    {
        $this->statusCode(400);
        $this->setDefaultHeader();
        echo json_encode(['status' => 'There is no such user with id: ' . $id . '!']);
    }

    public function sendOk($id = null, array $data = [], string $html = ''): void
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
        if (isset($_SESSION['action']) && $_SESSION['action'] === 'added') {
            $this->statusCode(201);
        }

        echo json_encode($this->responseBody);
    }

    public function sendNotValid(int $id, array $alerts): void
    {
        $this->responseBody['status'] = false;
        $this->responseBody['id'] = $id;
        $this->responseBody['alerts'] = $alerts;
        $this->statusCode(400);
        $this->setDefaultHeader();

        echo json_encode($this->responseBody);
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
