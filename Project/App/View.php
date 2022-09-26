<?php

namespace App;

class View
{
    private $viewsDir;

    public function __construct(string $viewsDir)
    {
        $this->viewsDir = $viewsDir;
    }

    public function renderHtml(string $template, array $vars = [])
    {
        extract($vars);

        ob_start();
        include $this->viewsDir . '/' . $template;
        $buffer = ob_get_contents();
        ob_end_clean();

        echo $buffer;
    }
}
