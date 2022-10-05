<?php
namespace App\Controllers;

use App\Alert;
use App\Response;
use App\Router;

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
        $this->view->renderHtml('User/Add.php', ['args' => ['title' => 'Add user']]);
    }

    public function store(): void
    {
        $_POST['id'] = time();
        $status = $this->user->add($_POST);
        $msg = $status ? 'User ' . $status['id'] . ' was added' : 'There was an error adding a user';
        Alert::setMsg($msg);
        $this->response->statusCode(200);
        $this->response->redirect('/');
        //$this->index(['status' => $msg, 'userData' => $status, 'title' => 'Main']);
    }

    public function delete(array $args)
    {
        $status =  $this->user->delete((int)$args['id']);
        //$status ? Alert::setMsg('User ' . $args['id'] . ' was deleted') : $this->router->exitWithError("Can't delete user. There is no user with this id - ");
        //$this->response->redirect('/');
        //$this->index(['status' => $msg, 'userData' => $status, 'title' => 'Main']);
        //$this->router->exitWithError(['User ID: ' . $args['id'] . ' was not deleted!']);
        //action was called with ajax and echo response is given
        //echo $status ? "User was deleted! (ID: %s, name: %s" : "No, wasn't deleted";
        echo $status ?
            json_encode([
                'status' => 'true',
                'redirect_url' => '/',
                'id' => $args['id'],
            ]) :
            json_encode([
                'status' => 'false',
                'redirect_url' => 'null',
                'id' => $args['id'],
            ]);

    }

    public function edit(array $args): void
    {
        $this->view->renderHtml('User/Edit.php', $this->getUserInfo($args['id']));
    }

    public function update(): void
    {
        parse_str(file_get_contents("php://input"),$post_vars);
        $status = $this->user->edit($post_vars);
        echo $status ?
            json_encode([
                'status' => 'true',
                'redirect_url' => '/',
                'id' => $post_vars['id'],
            ]) :
            json_encode([
                'status' => 'false',
                'redirect_url' => 'null',
                'id' => $post_vars['id'],
            ]);
    }

    public function getUserInfo(string $id): array
    {
        return $this->user->getUserInfo($id);
    }

    public function index(array $args = []): void
    {
        $users = $this->user->getAll();
        $this->view->renderHtml('User/ViewAll.php', ['users' => $users, 'args' => $args]);
    }

}