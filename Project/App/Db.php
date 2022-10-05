<?php

namespace App;

class Db
{
    private static $instance;
    private object $pdo;

    public function __construct()
    {
        $dbInit = (require __DIR__ . '/../Config/db.php')['db'];

        $this->pdo = new \PDO(
            'mysql:host=' . $dbInit['host'] . '; dbname=' . $dbInit['dbname'],
            $dbInit['user'],
            $dbInit['password']
        );
    }
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function changeRecord(string $sql, array $values): bool
    {
        $sth = $this->pdo->prepare($sql);
        return $sth->execute($values);
    }

    public function getRecord(string $sql, array $values): array|false
    {
        $sth = $this->pdo->prepare($sql);
        $sth->execute($values);
        return $sth->fetch(\PDO::FETCH_ASSOC);
    }

    public function getAll(): ?array
    {
        $result = $this->pdo->query('SELECT * FROM `users`');
        return $result->fetchAll() ?? null;
    }

    public function deleteRecord(string $sql, string $id): bool
    {
        $sth = $this->pdo->prepare($sql);
        return $sth->execute(['id' => $id]);
    }

    public function checkEmailExistence($email): array|bool
    {
        $sql = "SELECT * from `users` where `email` = :email";
        $sth = $this->pdo->prepare($sql);
        $sth->execute(['email' => $email]);
        return ($sth->fetch());
    }
}
