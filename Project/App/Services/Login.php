<?php

namespace App\Services;

class Login
{
    private $tokens;

    public function __construct(Tokens $tokens)
    {
        $this->tokens = $tokens;
    }

    public function login(array|false $user, string $password, bool $remember = false): bool
    {
        if ($user && isset($password) && password_verify($password, $user['password'])) {
            $this->logUserIn($user);

            if ($remember) {
                $this->rememberMe($user['id'], $this->tokens::TOKEN_LIFE);
            }

            return true;
        }

        return false;
    }

    private function logUserIn(array $user): bool
    {
        if (session_regenerate_id()) {
            $_SESSION['email'] = $user['email'];
            $_SESSION['id'] = $user['id'];

            return true;
        }

        return false;
    }

    private function rememberMe(int $id, int $tokenLife)
    {
        [$selector, $validator, $token] = $this->tokens->createTokens();
        $this->tokens->deleteToken($id);
        $expired_seconds = time() + $tokenLife;
        $hash_validator = password_hash($validator, PASSWORD_DEFAULT);
        $expiration = date('Y-m-d H:i:s', $expired_seconds);

        if ($this->tokens->insertToken($id, $selector, $hash_validator, $expiration)) {
            setcookie('remember_me', $token, $expired_seconds);
        }
    }
}
