<?php
namespace App\Controllers;

use App\View;
use App\Models\UserModel;
use App\Db;

class UserController
{
    private $view;
    private $user;
    private $db;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../Views');
        $this->user = new UserModel();
        $this->db = Db::getInstance();
    }
    public function add()
    {
        $this->user->addUserToDb($_POST);
        $this->view->renderHtml('User/Add.php', ['status' => $_POST['name']]);
    }

    public function delete()
    {
        $ids = array_keys($_POST);
        $this->user->deleteUserFromDb($ids);
        $this->view->renderHtml('User/Deleted.php', ['deletedCount' => count($_POST)]);

    }

    public function edit()
    {
        $this->user->editUserInDb($_POST);
        $this->view->renderHtml('User/Edited.php', ['name' => $_POST['name']]);
    }

    public function getUserInfo()
    {
        $record = $this->user->getUserInfo($_POST['id']);
        $this->view->renderHtml('User/Edit.php', $record);
    }

    public function view()
    {
        $users = $this->user->viewUserAllFromDb();
        if ($users) {
            $this->view->renderHtml('User/ViewAll.php', ['users' => $users]);
            return;
        }
        $this->view->renderHtml('User/NoUsers.html');
    }

}