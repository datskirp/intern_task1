<?php

namespace App;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class View
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function renderHtml(string $template, array $args = []): void
    {
        echo $this->twig->render($template, ['maxSize' => 10000000]);
    }

    public function render404(): void
    {

    }

    public function render400(): void
    {

    }
}
