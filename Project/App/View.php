<?php

namespace App;

class View
{
    public function render($template, array $args = []): string
    {
        extract($args, EXTR_SKIP);
        ob_start();
        include_once ROOT . '/Views/' . $template;
        $buffer = ob_get_contents();
        ob_end_clean();
        return $buffer;
    }

    public function renderError(int $statusCode, $msg): string
    {
        ob_start();
        include_once ROOT . '/Views/Error.php';
        $buffer = ob_get_contents();
        ob_end_clean();
        return $buffer;
    }
}

