<?php

namespace App\Services\Middleware;

use App\Services\Session;
use App\View;

class blockWithEmptyCart implements MiddlewareInterface
{
    private View $view;

    public function __construct(View $view)
    {
        $this->view = $view;
    }

    public function handle(Session $session, callable $next): bool
    {
        if (!$session->getCart() || !$session->getCart()->getItems()) {
            $session->errorView = $this->view->renderError(404, 'Page not found');

            return false;
        }

        return $next($session);
    }
}
