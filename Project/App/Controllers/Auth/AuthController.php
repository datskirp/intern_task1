<?php

namespace App\Controllers\Auth;

use App\Services\BlockByIp;
use App\Controllers\BaseController;
use App\Services\Session;
use App\Services\Tokens;

class AuthController extends BaseController
{
    public const ALLOWED_ATTEMPTS = 3;
    public $blockByIp;
    private $tokens;

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
        $validData = $this->user->validateSignUp($post_vars);
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
        if ($this->blockByIp->isBlocked()) {

            return $this->view->renderError(403, 'You are blocked');
        }

        return $this->view->render('User/Login.twig', ['title' => 'User authentication', 'args' => $args]);
    }

    public function authenticate(array $args = [])
    {
        if ($this->blockByIp->isAllowed()) {
            $user = $this->user::isRecord('email', $args['email']);
            if ($user && isset($args['password']) && password_verify($args['password'], $user['password'])) {
                // prevent session fixation attack
                Session::resetId();
                $_SESSION['email'] = $user['email'];
                $_SESSION['user_id'] = $user['id'];
                var_dump($_SESSION);
                return true;
            }
            $attemptsLeft = $this->blockByIp->addAttempt();
            if ($attemptsLeft == self::ALLOWED_ATTEMPTS) {
                $this->blockByIp->block($args['email']);
                return $this->view->renderError(427, 'You are blocked from logging in for ' . $this->blockByIp::BLOCK_TIMEOUT/60 . ' minutes');
            }
            $msg = self::ALLOWED_ATTEMPTS - $attemptsLeft > 1 ? 'There are ' . self::ALLOWED_ATTEMPTS - $attemptsLeft . ' attempts' :
                'There is one attempt';
            Session::createFlash(
                'action',
                'Log in failed. ' . $msg . ' left'
            );
            $this->response->redirect('/login');
        }
    }

    public function setBlockByIp(BlockByIp $blockByIp)
    {
        $this->blockByIp = $blockByIp;
    }

    public function setTokens(Tokens $tokens)
    {
        $this->tokens = $tokens;
    }
}
