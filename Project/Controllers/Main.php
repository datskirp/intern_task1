<?php
namespace Controllers;

use View\View;

class Main
{
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../Templates');
    }
    public function main()
    {
        $this->view->renderHtml('Main.php');
    }

    public function add()
    {
        $this->view->renderHtml('AddUser.php');
    }

}