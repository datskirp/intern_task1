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

        //action was called with ajax and echo response is given
        echo $status ? "yes, deleted" : "No, wasn't deleted";

    }

    public function edit(array $args): void
    {
        $this->view->renderHtml('User/Edit.php', ['args' => [$this->getUserInfo($args['id'])]]);
    }

    public function update(): void
    {
        $status= $this->user->edit($_POST);
        $msg = $status ? 'User ' . $status['id'] . ' was updated' : 'There was an error updating a user';
        //$this->index(['status' => $msg, 'userData' => $status, 'title' => 'Main']);
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