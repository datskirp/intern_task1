<?php

namespace App\Services;

use App\View;

class MiddlewareCopy
{
    private Login $login;
    private View $view;

    public function __construct(Login $login, View $view)
    {
        $this->login = $login;
        $this->view = $view;
    }

    public function isAuthorized()
    {
        return $this->login->isLoggedIn() ? true :
            $this->view->renderError(401, 'You are not authorized for this page');
    }

}