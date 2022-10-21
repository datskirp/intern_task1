<?php

namespace App;

class View
{
    public function render($template, array $args = []): void
    {
        extract($args, EXTR_SKIP);
        ob_start();
        include_once ROOT . '/Views/' . $template;
        $buffer = ob_get_contents();
        ob_end_clean();
        echo $buffer;
    }

    public function renderError(int $statusCode, $msg)
    {
        ob_start();
        include_once ROOT . '/Views/Error.php';
        $buffer = ob_get_contents();
        ob_end_clean();
        echo $buffer;
    }
}

