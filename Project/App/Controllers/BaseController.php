<?php

namespace App\Controllers;

use App\View;
use App\Session;
use App\Models\User\User;
use App\Response;

abstract class BaseController
{
    protected $view;
    protected $session;
    protected $user;
    protected $response;

    public function __construct(
        View $view,
        Session $session,
        User $user,
        Response $response,
    )
    {
        $this->view = $view;
        $this->session = $session;
        $this->user = $user;
        $this->response = $response;
    }
}
