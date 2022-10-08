<?php

namespace App;

class Request
{
    public function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function getUri()
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function boolGet()
    {
        return $this->getMethod() === 'get';
    }

    public function boolPost()
    {
        return $this->getMethod() === 'post';
    }

    public function getData()
    {
        $data = [];
        if ($this->boolGet()) {
            foreach ($_GET as $key => $value) {
                $data[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if ($this->boolPost()) {
            foreach ($_POST as $key => $value) {
                $data[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $data;
    }
}
