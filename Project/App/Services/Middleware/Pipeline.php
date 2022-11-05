<?php

namespace App\Services\Middleware;

use App\Services\Middleware\Authorization;
use App\Services\Session;
use DI\Container;

class Pipeline
{
    private array $middleware;

    public function __construct(array $middleware)
    {
        $this->middleware = $middleware;
    }

    public function handle(Session $session): bool
    {
        $middleware = array_shift($this->middleware);
        if ($middleware !== null) {
            return $middleware->handle($session, [$this, 'handle']);
        }

        return true;
    }

}