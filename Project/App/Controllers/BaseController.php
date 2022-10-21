<?php

namespace App\Controllers;

use App\Validator\ApiValidator;
use App\View;
use App\Session;
use App\Models\User\User;
use App\Response;
use App\Validator\UserValidator;

abstract class BaseController
{
    protected $view;
    protected $session;
    protected $user;
    protected $response;
    protected $validator;
    protected $apiValidator;

    public function __construct(
        View $view,
        Session $session,
        User $user,
        Response $response,
        UserValidator $validator,
        ApiValidator $apiValidator
    )
    {
        $this->view = $view;
        $this->session = $session;
        $this->user = $user;
        $this->response = $response;
        $this->validator = $validator;
        $this->apiValidator = $apiValidator;
    }
}
