<?php
namespace App\Controllers;

use App\View;

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

}