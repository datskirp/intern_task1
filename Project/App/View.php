<?php

namespace View;

class View
{
    private $templatesDir;

    public function __construct(string $templatesDir)
    {
        $this->templatesDir = $templatesDir;
    }

    public function renderHtml(string $template, array $vars = [])
    {
        extract($vars);

        ob_start();
        include $this->templatesDir . '/' . $template;
        $buffer = ob_get_contents();
        ob_end_clean();

        echo $buffer;
    }
}
