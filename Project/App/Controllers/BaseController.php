<?php

namespace App\Controllers;

use App\View;
use App\Models\User;
use App\Validator\Validator;
use App\Response;

abstract class BaseController
{
    protected View $view;
    protected User $user;
    protected Validator $validator;
    protected Response $response;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../Views');
        $this->user = new User();
        $this->validator = new Validator();
        $this->response = new Response();
    }
}
