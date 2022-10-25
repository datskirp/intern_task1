<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Session;

class AuthController extends BaseController
{
    public function register(array $args = []): string
    {
        $flash = Session::getFlash('action');
        if ($flash) {
            $args['flash'] = $flash;
            //Session::stop();
        }

        return $this->view->render('User/Register.twig', ['title' => 'User authentication', 'args' => $args]);
    }
}