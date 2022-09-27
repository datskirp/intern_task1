<?php
namespace App\Controllers;

use App\View;
use App\Db;

class MainController
{
    private $view;
    private $db;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../Views');
        $this->db = Db::getInstance();
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
        $users = $this->db->getAll();
        if ($users) {
            $this->view->renderHtml('User/Delete.php', ['users' => $users]);
            return;
        }
        $this->view->renderHtml('User/NoUsers.html');
    }

    public function edit()
    {
        $users = $this->db->getAll();
        if ($users) {
            $this->view->renderHtml('User/EditPickUser.php', ['users' => $users]);
            return;
        }
        $this->view->renderHtml('User/NoUsers.html');
    }

}