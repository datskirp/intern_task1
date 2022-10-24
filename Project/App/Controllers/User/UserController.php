<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

class UserController extends BaseController
{
    public function create(): string
    {
        return $this->view->render('User/Add.twig');
    }

    public function store(): string
    {
        $post_vars = json_decode(file_get_contents('php://input'), true);
        $post_vars['id'] = time();
        $validData = $this->user->validate($post_vars);
        $validData ?
            $status = $this->user->insert($validData) :
            $status = false;
        if ($status) {
            $this->session->setSessionMsg('added', $validData['id']);
        }

        return $this->response->send($status, $post_vars['id'], '/', $this->user->validator->getErrors());
    }

    public function delete(array $args): string
    {
        $status = $this->user->delete((int)$args['id']);
        if ($status) {
            $this->session->setSessionMsg('deleted', (int)$args['id']);
        }

        return $this->response->send($status, (int)$args['id'], '/');
    }

    public function edit(array $args): string
    {
        $user = $this->user::getById($args['id']);
        if ($user) {
            return $this->view->render('User/Edit.twig', ['user' => $user]);
        }

        return $this->view->renderError(404, 'The page you are looking for is not found');
    }

    public function update(array $arg = []): string
    {
        $put_vars = json_decode(file_get_contents('php://input'), true);

        $this->user->validate($put_vars) ?
            $status = $this->user->update($put_vars) :
            $status = false;
        if ($status) {
            $this->session->setSessionMsg('updated', $put_vars['id']);
        }

        return $this->response->send((bool)$status, $put_vars['id'], '/', $this->user->validator->getErrors());
    }

    public function show(array $args): string
    {
        $user = $this->user::getById($args['id']);
        if ($user) {
            return $this->view->render('User/Show.twig', ['user' => $user]);
        }

        return $this->view->renderError(404, 'The page you are looking for is not found');
    }

    public function index(array $args = []): string
    {
        if (isset($_SESSION['action'])) {
            $args['action'] = $_SESSION['action'];
            $args['msg'] = $_SESSION['id'];
            $this->session->stop();
        }
        $users = $this->user->getAll();

        return $this->view->render('User/ViewAll.twig', ['users' => $users, 'args' => $args]);
    }
}
