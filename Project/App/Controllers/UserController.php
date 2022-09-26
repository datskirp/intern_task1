<?php
namespace Controllers;

use View\View;

class AddUser
{
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../ViewTemplates');
    }
    public function main()
    {
        $this->view->renderHtml('Add.php');
    }

}