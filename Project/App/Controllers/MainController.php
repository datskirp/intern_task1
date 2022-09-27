<?php
namespace App\Controllers;

use App\View;
use App\Db;

class MainController
{
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../Views');
    }
    public function main()
    {
        $this->view->renderHtml('Main.php');
    }

    public function add()
    {
        $this->view->renderHtml('User/Add.php');
    }
    public function delete()
    {
        $user = new Db();
        $users = $user->getAll();
        if ($users) {
            $this->view->renderHtml('User/Delete.php', ['users' => $users]);
            return;
        }
        $this->view->renderHtml('User/NoUsers.html');
    }

}