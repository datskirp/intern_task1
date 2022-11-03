<?php

namespace App\Services\Middleware;

use App\Services\Session;

class isGuest implements MiddlewareInterface
{

    public function handle(Session $session, callable $next): bool
    {
        // TODO: Implement handle() method.
    }
}