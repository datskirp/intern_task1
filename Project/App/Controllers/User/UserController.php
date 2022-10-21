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

    public function delete(array $args): string
    {
        $status = $this->user->delete((int)$args['id']);
        if ($status) {
            $this->session->setSessionMsg('deleted', (int)$args['id']);
        }

        return $this->response->send($status, [], (int)$args['id'], '/');
    }

    public function edit(array $args): string
    {
        $user = $this->user::getById($args['id']);
        if ($user) {
            return $this->view->render('User/Edit.php', ['user' => $user]);
        }

        return $this->view->renderError(404, 'The page you are looking for is not found');
    }

    public function update(): string
    {
        $put_vars = json_decode(file_get_contents('php://input'), true);

        $this->validator->validateUser($put_vars) ?
            $status = $this->user->update($put_vars) :
            $status = false;
        if ($status) {
            $this->session->setSessionMsg('updated', $put_vars['id']);
        }

        return $this->response->send((bool)$status, $this->validator->getErrors(), $put_vars['id'], '/');
    }

    public function show(array $args): string
    {
        $user = $this->user::getById($args['id']);
        if ($user) {
            return $this->view->render('User/Show.php', ['user' => $user]);
        }

        return $this->view->renderError(404, 'The page you are looking for is not found');
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
