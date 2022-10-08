<?php

namespace App\Controllers;

use App\View;
use App\Models\User;
use App\Validator\Validator;

abstract class BaseController
{
    protected View $view;
    protected User $user;
    protected Validator $validator;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../Views');
        $this->user = new User();
        $this->validator = new Validator();
    }

    public function validateRules()
    {
        return [
            'email' => ['required', 'email', 'unique'],
            'name' => ['required', 'name'],
        ];
    }
}
