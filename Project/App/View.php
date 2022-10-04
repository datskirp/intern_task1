<?php

namespace App;

class View
{
    private string $dir;

    public function __construct(string $dir)
    {
        $this->dir = $dir;
    }

    public function renderHtml(string $template, array $args = []): void
    {
        //$content = include_once $this->dir . '/' . $template;
        extract($args);
        Alert::resetMsg();
        ob_start();
        include_once $this->dir . '/' . $template;
        $buffer = ob_get_contents();
        ob_end_clean();
        echo $buffer;
    }

}
