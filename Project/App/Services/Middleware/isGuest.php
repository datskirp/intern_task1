<?php

namespace App\Services\Middleware;

use App\Services\Login;
use App\Services\Session;

class isGuest implements MiddlewareInterface
{

    private Login $login;

    public function __construct(Login $login)
    {
        $this->login = $login;
    }

    public function handle(Session $session, callable $next): bool
    {
        if (!$this->login->isLoggedIn()) {
            $session->setLogin('', 0);
        }

        return $next($session);
    }
}