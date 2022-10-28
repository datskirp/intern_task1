<?php

namespace App\Controllers\Auth;

use App\Services\BlockByIp;
use App\Controllers\BaseController;
use App\Services\Session;
use App\Services\Login;

class AuthController extends BaseController
{
    public const ALLOWED_ATTEMPTS = 3;
    private BlockByIp $blockByIp;
    private Login $login;

    public function register($args = []): string
    {
        $flash = Session::getFlash('msg');
        if ($flash) {
            $args['flash'] = $flash;
        }

        return $this->view->render('User/Register.twig', ['title' => 'User registration', 'args' => $args]);
    }

    public function signUp(): string
    {
        $post_vars = json_decode(file_get_contents('php://input'), true);
        $validData = $this->user->validateSignUp($post_vars);
        $validData ?
            $status = $this->user->insert($validData) :
            $status = false;
        if ($status) {
            Session::createFlash('msg', 'Created ' . $validData['first_name'] . ' ' . $validData['last_name'] . ' successfully');
        }

        return $this->response->send($status, '/register', $this->user->validator->getErrors());
    }

    public function login($args = []): string
    {
        $flash = Session::getFlash('msg');
        if ($flash) {
            $args['flash'] = $flash;
            //Session::stop();
        }
        if ($this->blockByIp->isBlocked()) {
            return $this->view->renderError(403, 'You are blocked');
        }

        return $this->view->render('User/Login.twig', ['title' => 'User authentication', 'args' => $args]);
    }

    public function authenticate(array $args = [])
    {
        if ($this->blockByIp->isAllowed()) {
            $user = $this->user::isRecord('email', $args['email']);

            if ($this->login->login($user, $args['password'], isset($args['remember_me']))) {
                $this->response->redirect('/upload');
            }

            $attemptsLeft = $this->blockByIp->addAttempt();

            if ($attemptsLeft == self::ALLOWED_ATTEMPTS) {
                $this->blockByIp->block($args['email']);

                return $this->view->renderError(
                    427,
                    'You are blocked from logging in for ' . $this->blockByIp::BLOCK_TIMEOUT / 60 . ' minutes'
                );
            }
            $msg = 'Invalid email or password' . PHP_EOL;
            $msg .= self::ALLOWED_ATTEMPTS - $attemptsLeft > 1 ? 'There are ' . self::ALLOWED_ATTEMPTS - $attemptsLeft . ' attempts' :
                'There is one attempt';
            Session::createFlash(
                'msg',
                'Log in failed. ' . $msg . ' left'
            );
            $this->response->redirect('/login');
        }
    }

    public function setBlockByIp(BlockByIp $blockByIp)
    {
        $this->blockByIp = $blockByIp;
    }

    public function setLogin(Login $login)
    {
        $this->login = $login;
    }
}
