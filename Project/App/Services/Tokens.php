<?php

namespace App\Services;

class Tokens
{
    const TOKEN_TABLE = 'user_tokens';
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
        /*
        $sql = 'INSERT INTO `user_tokens` (`user_id`, `selector`, `validator`, `expiration`)
            VALUES (:user_id, :selector, :validator, :expiration)';

        return $this->db->changeRecord($sql, [
            'user_id' => $user_id,
            'selector' => $selector,
            'validator' => $validator,
            'expiration' => $expiration,
        ]);
        */
    }

    public function findUserTokenBySelector(string $selector): ?array
    {
        return $this->db->select()
            ->from(self::TOKEN_TABLE)
            ->where()
        /*
        $sql = 'SELECT `id`, `selector`, `validator`, `user_id`, `expiration`
                FROM `user_tokens`
                WHERE selector = :selector AND
                    expiration >= now()
                LIMIT 1';

        return $this->db->query($sql, ['selector' => $selector]);
        */
    }

    public function deleteToken(int $id): bool
    {
        $sql = 'DELETE FROM `user_tokens` WHERE `user_id` = :user_id';

        return $this->db->changeRecord($sql, ['user_id' => $id]);
    }

    public function findUserByToken(string $token): ?array
    {
        $tokens = $this->splitToken($token);

        if (!$tokens) {
            return null;
        }

        $sql = 'SELECT `users.id`, `email`
            FROM `users`
            INNER JOIN `user_tokens` ON user_id = users.id
            WHERE selector = :selector AND
                expiry > now()
            LIMIT 1';

        return $this->db->query($sql, ['selector' => $tokens[0]]);
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
