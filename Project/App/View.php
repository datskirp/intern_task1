<?php

namespace App;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class View
{
    private $twig;
    private int $maxFileSize;

    public function __construct(Environment $twig, int $maxFileSize)
    {
        $this->twig = $twig;
        $this->maxFileSize = $maxFileSize;
    }

    public function renderHtml(string $template, array $args = []): string
    {
        $args['maxSize'] = $this->maxFileSize;
        return $this->twig->render($template, $args);
    }

    public function render404($template)
    {
        return $this->twig->render($template, ['msg' => 'Page you are looking for is not found']);
    }

    public function render400($template)
    {
        return $this->twig->render($template, ['msg' => 'There is a problem uploading a file.']);
    }
}
