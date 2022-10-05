<?php
namespace App\Controllers;

use App\Response;
use App\Router;
use App\Validator;
use App\Db;

class UserController extends BaseController
{
    private Response $response;
    private Router $router;

    public function __construct()
    {
        parent::__construct();
        $this->response = new Response();
        $this->router = new Router();
    }

    public function create(): void
    {
        $this->view->renderHtml('User/Add.php');
    }

    public function store(): void
    {
        parse_str(file_get_contents("php://input"),$post_vars);
        $post_vars['id'] = time();
        $validator = Validator::getInstance();
        $validator::deleteErrorMessages();
        $validator::validate($post_vars);
        $validator::isValid() ?
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
                'errors' => $validator::$errorMessages,
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
        $this->response->redirect('/404');
        $this->router->exitWithError(['User: "' . $args['id'] . '" you entered is not found!']);

    }

    public function index(array $args = []): void
    {
        $users = $this->user->getAll();
        $this->view->renderHtml('User/ViewAll.php', ['users' => $users, 'args' => $args]);
    }

}