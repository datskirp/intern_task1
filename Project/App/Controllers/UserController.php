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
        $post_vars = json_decode(file_get_contents("php://input"), true);
        $post_vars['id'] = time();
        $this->validator->validate($post_vars, $this->validateRules());
        $this->validator->isValid() ?
            $status = $this->user->add($post_vars) :
            $status = false;

        $this->response->send((bool)$status, $this->validator->getAlerts(), $post_vars['id'], '/');
    }

    public function delete(array $args): void
    {
        $status =  $this->user->delete((int)$args['id']);
        $this->response->send($status, $this->validator->getAlerts(), $args['id'], '/');
    }

    public function edit(array $args): void
    {
        $this->view->renderHtml('User/Edit.php', $this->user->getUserById($args['id']));
    }

    public function update(): void
    {
        $put_vars = json_decode(file_get_contents("php://input"), true);
        $this->validator->validate($put_vars, $this->validateRules());
        $this->validator->isValid() ?
            $status = $this->user->edit($put_vars) :
            $status = false;

        $this->response->send((bool)$status, $this->validator->getAlerts(), $put_vars['id'], '/');
    }

    public function show(array $args)
    {
        $user = $this->user->getUserById($args['id']);
        $this->view->renderHtml('User/Show.php', $user);
    }

    public function index(array $args = []): void
    {
        $users = $this->user->getAll();
        $this->view->renderHtml('User/ViewAll.php', ['users' => $users, 'args' => $args]);
    }

}