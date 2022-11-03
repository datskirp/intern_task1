<?php

namespace App\Services;


class Login
{
    private $tokens;
    private $session;

    public function __construct(Tokens $tokens, Session $session)
    {
        $this->tokens = $tokens;
        $this->session = $session;
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
            $this->session->setLogin($user['email'], $user['id']);

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

    public function logout(): void
    {
        if ($this->isLoggedIn()) {
            $this->tokens->deleteToken($this->session->getId());
            if (isset($_COOKIE['remember_me'])) {
                unset($_COOKIE['remember_me']);
            }
            Session::stop();
        }
    }

    public function isLoggedIn(): bool
    {
        if ($this->session->getId()) {
            return true;
        }
        $token = filter_input(INPUT_COOKIE, 'remember_me', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ($token && $this->tokens->isTokenValid($token)) {

            $user = $this->tokens->findUserByToken($token);

            if ($user) {
                return $this->logUserIn($user);
            }
        }
        return false;
    }
}
