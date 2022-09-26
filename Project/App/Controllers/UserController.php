<?php
namespace App\Controllers;

use App\View;
use App\Models\UserModel;

class UserController
{
    private $view;
    private $user;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../Views');
        $this->user = new UserModel();
    }
    public function add()
    {
        echo "inside add usercontroller";
        if ($this->user->addUserToDb($_POST) ) {
            $this->view->renderHtml('User/Add.php', ['status' => $_POST['name'] .' has been added']);
        }


    }

}