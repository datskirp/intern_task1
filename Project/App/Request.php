<?php

namespace App;

class Request
{
    public static function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public static function getUri(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    public static function getFile(): ?array
    {
        return $_FILES;
    }
}
