<?php

namespace App\Services;

class Tokens
{
    const TOKEN_LIFE = 168 * 60 * 60; // seconds
    private Db $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }


    function createTokens(): array
    {
        $selector = bin2hex(random_bytes(16));
        $validator = bin2hex(random_bytes(32));

        return [$selector, $validator, $selector . ':' . $validator];
    }

    function splitToken(string $token): ?array
    {
        $parts = explode(':', $token);

        if ($parts && count($parts) == 2) {
            return [$parts[0], $parts[1]];
        }
        return null;
    }

    function insertToken(int $user_id, string $selector, string $hashed_validator, string $expiration): bool
    {
        $sql = 'INSERT INTO `user_tokens` (`user_id`, `selector`, `hashed_validator`, `expiration`)
            VALUES (:user_id, :selector, :hashed_validator, :expiration)';

        return $this->db->changeRecord($sql, [
            'user_id' => $user_id,
            'selector' => $selector,
            'hashed_validator' => $hashed_validator,
            'expiration' => $expiration,
            ]);

        $statement = db()->prepare($sql);
        $statement->bindValue(':user_id', $user_id);
        $statement->bindValue(':selector', $selector);
        $statement->bindValue(':hashed_validator', $hashed_validator);
        $statement->bindValue(':expiry', $expiry);

        return $statement->execute();
    }

    function find_user_token_by_selector(string $selector)
    {

        $sql = 'SELECT id, selector, hashed_validator, user_id, expiry
                FROM user_tokens
                WHERE selector = :selector AND
                    expiry >= now()
                LIMIT 1';

        $statement = db()->prepare($sql);
        $statement->bindValue(':selector', $selector);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    function deleteToken(int $id): bool
    {
        $sql = 'DELETE FROM `user_tokens` WHERE `user_id` = :user_id';

        return $this->db->changeRecord($sql, ['user_id' => $id]);
    }

    function find_user_by_token(string $token)
    {
        $tokens = parse_token($token);

        if (!$tokens) {
            return null;
        }

        $sql = 'SELECT users.id, username
            FROM users
            INNER JOIN user_tokens ON user_id = users.id
            WHERE selector = :selector AND
                expiry > now()
            LIMIT 1';

        $statement = db()->prepare($sql);
        $statement->bindValue(':selector', $tokens[0]);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }




}