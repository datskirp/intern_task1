<?php

namespace App\Services\Middleware;

use App\View;
use App\Services\Login;
use App\Services\Session;

class Authorization implements MiddlewareInterface
{
    private Login $login;
    private View $view;

    public function __construct(Login $login, View $view)
    {
        $this->login = $login;
        $this->view = $view;
    }

    public function handle(Session $session, callable $next): bool
    {
        if (!$this->login->isLoggedIn()) {
            $session->errorView = $this->view->renderError(401, 'You are not authorized for this page');
            return false;
        }
        return true;
    }
}