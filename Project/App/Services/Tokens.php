<?php

namespace App\Services;

class Tokens
{
    public const TOKEN_TABLE = 'user_tokens';
    public const USER_TABLE = 'users';
    public const TOKEN_LIFE = 168 * 60 * 60; // seconds
    private Db $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }


    public function createTokens(): array
    {
        $selector = bin2hex(random_bytes(16));
        $validator = bin2hex(random_bytes(32));

        return [$selector, $validator, $selector . ':' . $validator];
    }

    public function splitToken(string $token): ?array
    {
        $parts = explode(':', $token);

        if ($parts && count($parts) == 2) {
            return [$parts[0], $parts[1]];
        }

        return null;
    }

    public function insertToken(int $user_id, string $selector, string $validator, string $expiration): bool
    {
        return $this->db->insert(self::TOKEN_TABLE)
            ->columns(['user_id', 'selector', 'validator', 'expiration'])
            ->values([
                'user_id' => $user_id,
                'selector' => $selector,
                'validator' => $validator,
                'expiration' => $expiration,
            ])
            ->do();
    }

    public function findUserTokenBySelector(string $selector): array|false
    {
        return $this->db->select()
            ->from(self::TOKEN_TABLE)
            ->where(['selector' => $selector], '= :')
            ->and(['expiration' => 'now()'], '>=')
            ->getOne();
    }

    public function deleteToken(int $id): bool
    {
        return $this->db->delete(self::TOKEN_TABLE)
            ->where(['user_id' => $id], '= :')
            ->do();
    }

    public function findUserByToken(string $token): ?array
    {
        $tokens = $this->splitToken($token);

        if (!$tokens) {
            return null;
        }
        [$selector, $validator] = $tokens;

        return $this->db->select(['user_id', 'email'])
            ->from(self::USER_TABLE)
            ->where(['selector' => $selector], '= :')
            ->and(['expiration' => 'now()'], '>')
            ->limit(1)
            ->getOne();
    }

    public function isTokenValid(string $token): bool
    {
        [$selector, $validator] = $this->splitToken($token);
        $tokens = $this->findUserTokenBySelector($selector);
        if (!$tokens) {
            return false;
        }

        return password_verify($validator, $tokens['validator']);
    }
}
