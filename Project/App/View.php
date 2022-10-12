<?php

namespace App;

class View
{
    private string $dir;

    public function __construct(string $dir)
    {
        $this->dir = $dir;
    }

    private function insertHeader(): string
    {
        return include_once $this->dir . '/header.php';
    }

    private function insertFooter(): string
    {
        return include_once $this->dir . '/footer.php';
    }

    private function insertContent(string $template): string
    {
        return include_once $this->dir . '/' . $template;
    }



    public function renderHtml(string $template, array $args = []): void
    {
        extract($args, EXTR_SKIP);
        ob_start();
        $this->insertHeader();
        $this->insertContent($template);
        $this->insertFooter();
        $buffer = ob_get_contents();
        ob_end_clean();
        echo $buffer;
    }
}
