<?php

namespace App\Controllers\User;

use App\View;
use App\Session;
use App\Models\User\User;
use App\Response;

class UserController
{
    private $view;
    private $session;
    private $user;
    private $response;

    public function __construct(View $view, Session $session, User $user, Response $response)
    {
        $this->view = $view;
        $this->session = $session;
        $this->user = $user;
        $this->response = $response;
        var_dump($user);
    }


    public function create(): void
    {
        $this->view->render('User/Add.php');
    }

    public function store(): void
    {
        $post_vars = json_decode(file_get_contents('php://input'), true);
        $post_vars['id'] = time();
        $this->user->store($post_vars) ?
            $status = $this->user->add($post_vars) :
            $status = false;
        if ($status) {
            $this->response->setSessionMsg('added', $post_vars['id']);
        }
        $this->response->send((bool)$status, $this->validator->getAlerts(), $post_vars['id'], '/');
    }

    public function delete(array $args): void
    {
        $status = $this->user->delete((int)$args['id']);
        if ($status) {
            $this->response->setSessionMsg('deleted', (int)$args['id']);
        }
        $this->response->send($status, $this->validator->getAlerts(), (int)$args['id'], '/');
    }

    public function edit(array $args): void
    {
        $user = $this->user->getUserById($args['id']);
        if ($user !== false) {
            $this->view->render('User/Edit.php', $user);
        } else {
            $this->view->render('Error.php', ['msg' => 'This url is not found!']);
        }
        //$this->view->renderHtml('User/Edit.php', $this->user->getUserById($args['id']));
    }

    public function update(): void
    {
        $put_vars = json_decode(file_get_contents('php://input'), true);
        $this->validator->validate($put_vars, $this->validator->userValidatorRules());
        $this->validator->isValid() ?
            $status = $this->user->edit($put_vars) :
            $status = false;
        if ($status) {
            $this->response->setSessionMsg('updated', $put_vars['id']);
        }
        $this->response->send((bool)$status, $this->validator->getAlerts(), $put_vars['id'], '/');
    }

    public function show(array $args)
    {
        $user = $this->user->getUserById($args['id']);
        if ($user !== false) {
            $this->view->render('User/Show.php', $user);
        } else {
            $this->view->render('Error.php', ['msg' => 'This url is not found!']);
        }

    }

    public function index(array $args = []): void
    {
        if (isset($_SESSION['action'])) {
            $args['action'] = $_SESSION['action'];
            $args['msgID'] = $_SESSION['id'];
            $this->session->stop();
        }
        $users = $this->user->getAll();
        var_dump($users);
        $this->view->render('User/ViewAll.php', ['users' => $users, 'args' => $args]);
    }
}
