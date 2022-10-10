<?php

namespace App\Controllers;

class UserController extends BaseController
{
    public function create(): void
    {
        $this->view->renderHtml('User/Add.php');
    }

    public function store(): void
    {
        $post_vars = json_decode(file_get_contents('php://input'), true);
        $post_vars['id'] = time();
        $this->validator->validate($post_vars, $this->validator->userValidatorRules());
        $this->validator->isValid() ?
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
        $this->view->renderHtml('User/Edit.php', $this->user->getUserById($args['id']));
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
        $this->view->renderHtml('User/Show.php', $user);
    }

    public function index(array $args = []): void
    {
        if (!isset($_SESSION)) {
            $this->response->startSession();
        }
        if (isset($_SESSION['action'])) {
            $args['action'] = $_SESSION['action'];
            $args['msgID'] = $_SESSION['id'];
            $this->response->stopSession();
        }
        $users = $this->user->getAll();
        $this->view->renderHtml('User/ViewAll.php', ['users' => $users, 'args' => $args]);
    }
}
