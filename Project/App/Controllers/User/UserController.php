<?php

namespace App\Controllers\User;


class UserController extends BaseController
{
    public function create(): string
    {
        return $this->view->render('User/Add.php');
    }

    public function store(): string
    {
        $post_vars = json_decode(file_get_contents('php://input'), true);
        $post_vars['id'] = time();

        $this->validator->validateUser($post_vars) ?
            $status = $this->user->insert($post_vars) :
            $status = false;
        //var_dump($status);
        if ($status) {
            $this->session->setSessionMsg('added', $post_vars['id']);
        }
        return $this->response->send((bool)$status, $this->validator->getErrors(), $post_vars['id'], '/');
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

    public function index(array $args = []): string
    {
        if (isset($_SESSION['action'])) {
            $args['action'] = $_SESSION['action'];
            $args['msgID'] = $_SESSION['id'];
            $this->session->stop();
        }
        $users = $this->user->getAll();
        return $this->view->render('User/ViewAll.php', ['users' => $users, 'args' => $args]);
    }
}
