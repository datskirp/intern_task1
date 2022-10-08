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
        parse_str(file_get_contents("php://input"),$post_vars);

        //var_dump(getallheaders());

        $post_vars['id'] = time();
        $this->validator->validate($post_vars, $this->validateRules());

        var_dump($this->validator->isValid());

        $this->validator->isValid() ?
            $status = $this->user->add($post_vars) :
            $status = false;

        echo $status ?
            json_encode([
                'status' => 'true',
                'redirect_url' => '/',
                'id' => $post_vars['id'],
                'action' => 'add',
            ]) :
            json_encode([
                'status' => 'false',
                'redirect_url' => 'null',
                'errors' => $this->validator->getAlerts(),
            ]);


    }

    public function delete(array $args)
    {
        $status =  $this->user->delete((int)$args['id']);

        echo $status ?
            json_encode([
                'status' => 'true',
                'redirect_url' => '/',
                'id' => $args['id'],
                'action' => 'delete',
            ]) :
            json_encode([
                'status' => 'false',
                'redirect_url' => 'null',
                'id' => $args['id'],
            ]);

    }

    public function edit(array $args): void
    {
        $this->view->renderHtml('User/Edit.php', $this->user->show($args['id']));
    }

    public function update(): void
    {
        parse_str(file_get_contents("php://input"),$post_vars);
        $validator = Validator::getInstance();
        $validator::deleteErrorMessages();
        $validator::validate($post_vars);
        $validator::isValid() ?
            $status = $this->user->edit($post_vars) :
            $status = false;
        echo $status ?
            json_encode([
                'status' => 'true',
                'redirect_url' => '/',
                'id' => $post_vars['id'],
                'action' => 'update',
            ]) :
            json_encode([
                'status' => 'false',
                'redirect_url' => 'null',
                'id' => $post_vars['id'],
                'errors' => $validator::$errorMessages,
            ]);
    }

    public function show(array $args)
    {
        $user = $this->user->show($args['id']);
        if($user)
            return $user;
    }

    public function index(array $args = []): void
    {
        $users = $this->user->getAll();
        $this->view->renderHtml('User/ViewAll.php', ['users' => $users, 'args' => $args]);
    }

}