<?php

namespace App\Services\Middleware;

use App\Services\Session;

interface MiddlewareInterface
{
    public function handle(Session $session, callable $next): bool;
}