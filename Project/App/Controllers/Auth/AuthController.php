<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Session;

class AuthController extends BaseController
{
    public function register($args = []): string
    {
        $flash = Session::getFlash('action');
        if ($flash) {
            $args['flash'] = $flash;
            //Session::stop();
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

    public function login($args = []): string
    {
        $flash = Session::getFlash('action');
        if ($flash) {
            $args['flash'] = $flash;
            //Session::stop();
        }
        $args['msg'] = $_SESSION['msg'];

        return $this->view->render('User/Login.twig', ['title' => 'User authentication', 'args' => $args]);
    }

    public function authenticate(array $args = [])
    {


        $user = $this->user::isRecord(key($args), $args[key($args)]);
        if ($user && isset($args['password']) && password_verify($args['password'], $user['password'])) {


            // prevent session fixation attack
            session_regenerate_id();

            // set username in the session
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_id']  = $user['id'];



        }

        $this->response->redirect('/login');

    }
}
