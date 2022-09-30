<?php

namespace App;

class View
{
    private $dir;

    public function __construct(string $dir)
    {
        $this->dir = $dir;
    }

    public function renderHtml(string $template, array $vars = []): void
    {
        extract($vars);
        ob_start();
        include $this->dir . '/' . $template;
        $buffer = ob_get_contents();
        ob_end_clean();
        echo $buffer;
    }

}
