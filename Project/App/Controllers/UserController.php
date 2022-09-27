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
        $this->db = new Db();
    }
    public function add()
    {
        if ($this->user->addUserToDb($_POST) ) {
            $this->view->renderHtml('User/Add.php', ['status' => $_POST['name'] .' has been added']);
        }
    }

    public function delete()
    {

        $ids['ids'] = implode(", ", array_keys($_POST));
         $this->db->getUsersCount() == count($_POST) ? $this->user->deleteUserAllFromDb() :
            $this->user->deleteUserFromDb($ids);
        $this->view->renderHtml('User/Deleted.html', ['deletedCount' => count($_POST)]);

    }

    public function View()
    {
        $users = $this->user->viewUserAllFromDb();
        if ($users) {
            $this->view->renderHtml('User/ViewAll.php', ['users' => $users]);
            return;
        }
        $this->view->renderHtml('User/NoUsers.html');
    }

}