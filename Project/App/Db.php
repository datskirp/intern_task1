<?php

namespace App;

use http\Env\Request;
use http\Exception;

class Db
{
    private $pdo;
    private static $instance;

    public function __construct()
    {
        $dbInit = (require __DIR__ . '/../Config/DbSettings.php')['db'];

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

    public function getUsersCount()
    {
        return $this->pdo->query('SELECT COUNT(*) FROM `users`')->fetchColumn();
    }

    public function insertRecord(string $sql, array $values): bool
    {
        $sth = $this->pdo->prepare($sql);
        return $sth->execute($values);
    }

    public function editRecord(string $sql, array $values): bool
    {
        $sth = $this->pdo->prepare($sql);
        return $sth->execute($values);
    }

    public function getRecord(string $sql, array $values): array
    {
        $sth = $this->pdo->prepare($sql);
        $sth->execute($values);
        return $sth->fetch(\PDO::FETCH_ASSOC);
    }
    public function getAll(): ?array
    {
        $result = $this->pdo->query('SELECT * FROM `users`');

        return $result ? $result->fetchAll() : null;
    }

    public function deleteRecord(string $sql, array $ids = []): bool
    {
        $sth = $this->pdo->prepare($sql);
        return $sth->execute($ids);
    }
}
