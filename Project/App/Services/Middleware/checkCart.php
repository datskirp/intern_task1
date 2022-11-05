<?php

namespace App\Services\Middleware;

use App\Models\Cart\GuestCart;
use App\Models\Cart\UserCart;
use App\Services\Session;

class checkCart implements MiddlewareInterface
{
    

    public function handle(Session $session, callable $next): bool
    {
        if (!$session->getCart()) {
            $user = $session->getId();
            if(!$user) {
                $session->createCart(new GuestCart());
                return $next($session);
            }
            $session->createCart(new UserCart($user));
            $session->getCart()->loadFromDb($user);
            return $next($session);
        }

        return $next($session);
    }
}