<?php

namespace App\Controllers;

use App\View;
use App\Models\User;

abstract class BaseController
{
    protected View $view;
    protected User $user;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../Views');
        $this->user = new User();
    }
}
