<?php
namespace Controllers;

use View\View;

class MainController
{
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../ViewTemplates');
    }
    public function main()
    {
        $this->view->renderHtml('MainController.php');
    }

    public function add()
    {
        $this->view->renderHtml('Add.php');
    }

}