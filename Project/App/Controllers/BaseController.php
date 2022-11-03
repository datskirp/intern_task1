<?php

namespace App\Controllers;

use App\Models\Product\Product;
use App\View;
use App\Services\Session;
use App\Models\User\User;
use App\Response;

abstract class BaseController
{
    protected $view;
    protected $session;
    protected $user;
    protected $response;
    protected $product;

    public function __construct(
        View $view,
        Session $session,
        User $user,
        Response $response,
        Product $product,
    )
    {
        $this->view = $view;
        $this->session = $session;
        $this->user = $user;
        $this->response = $response;
        $this->product = $product;
    }
}
