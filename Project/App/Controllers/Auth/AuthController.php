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
        }

        return $this->view->render('User/Register.twig', ['title' => 'User authentication', 'args' => $args]);
    }

    public function signUp(): string
    {
        $post_vars = json_decode(file_get_contents('php://input'), true);
        $validData = $this->user->validate($post_vars);
        $validData ?
            $status = $this->user->insert($validData) :
            $status = false;
        if ($status) {
            Session::createFlash('action', 'Created ' . $validData['first_name'] . ' ' . $validData['last_name'] . ' successfully');
        }

        return $this->response->send($status, '/register', $this->user->validator->getErrors());
    }
}
