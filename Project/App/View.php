<?php

namespace App;

use Twig\Environment;

class View
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }
    public function render($template, array $args = []): string
    {
        return $this->twig->render($template, $args);
    }

    public function renderError(int $statusCode, $msg): string
    {
        $view = 'Error.twig';
        return $this->twig->render($view, ['statusCode' => $statusCode, 'msg' => $msg]);
    }
}
