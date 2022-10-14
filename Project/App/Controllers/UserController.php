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
            $this->response->startSession();
            $this->response->setSessionMsg('added', $post_vars['id']);
            $this->response->sendOk($post_vars['id']);
        } else {
            $this->response->sendNotValid($post_vars['id'], $this->validator->getAlerts());
        }

    }

    public function delete(array $args): void
    {
        $status = $this->user->delete((int)$args['id']);
        if ($status) {
            $this->response->setSessionMsg('deleted', (int)$args['id']);
            $this->response->sendOk((int)$args['id']);
        }
        else {
            $this->response->send404();
        }
    }

    public function edit(array $args): void
    {
        if($this->user->getUserById($args['id'])) {
            $this->view->renderHtml('User/Edit.php', $args);
        } else {
            $this->view->renderHtml('404.php', ['msg' => 'User is not found']);
        }
    }

    public function update(array $args): void
    {
        $put_vars = json_decode(file_get_contents('php://input'), true);
        $put_vars['id'] = $args['id'];
        $this->validator->validate($put_vars, $this->validator->userValidatorRules());
        $this->validator->isValid() ?
            $status = $this->user->edit($put_vars) :
            $status = false;
        if ($status) {
            $this->response->setSessionMsg('updated', $put_vars['id']);
            $this->response->sendOk($put_vars['id']);
        } else {
            $this->response->sendNotValid($put_vars['id'], $this->validator->getAlerts());
        }
    }

    public function show(array $args)
    {
        $user = $this->user->getUserById($args['id']);
        if ($user !== false) {
            $this->response->sendOk(null, $user);
        } else {
            $this->response->send400($args['id']);
        }

    }

    public function showAll()
    {
        $users = $this->user->getAll();
        if (empty($users)) {
            $this->response->dbIdEmpty();
        } else {
            $this->response->sendOk(null, $users);
        }
    }

    public function index(array $args = []): void
    {
        session_start();
        /*
        if (!isset($_SESSION)) {
            $this->response->startSession();
        }
        */
        if (isset($_SESSION['action'])) {
            $args['action'] = $_SESSION['action'];
            $args['msgID'] = $_SESSION['id'];
            $this->response->stopSession();
        }
        //$users = $this->user->getAll();
        $this->view->renderHtml('User/Start.php', ['args' => $args]);
    }
}
