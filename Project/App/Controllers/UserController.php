<?php
namespace App\Controllers;

use App\View;

class User
{
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../Views');
    }
    public function add()
    {
        $this->view->renderHtml(self::class . '/Add.php');
    }

}