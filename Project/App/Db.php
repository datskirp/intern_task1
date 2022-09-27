<?php

namespace App;

class Db
{
    private $pdo;

    public function __construct()
    {
        $dbInit = (require __DIR__ . '/../Config/DbSettings.php')['db'];

        $this->pdo = new \PDO(
            'mysql:host=' . $dbInit['host'] . '; dbname=' . $dbInit['dbname'],
            $dbInit['user'],
            $dbInit['password']
        );
        $this->pdo->exec('SET NAMES UTF8');

        $this->resetAutoIncrement();
    }

    public function getUsersCount()
    {
        return $this->pdo->query('SELECT COUNT(*) FROM `users`')->fetchColumn();
    }

    public function insertRecord(string $sql, array $values):bool
    {
        $sth = $this->pdo->prepare($sql);
        return $sth->execute($values);
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

    private function resetAutoIncrement()
    {
        if ($this->getAll() === null) {
            $this->pdo->query('ALTER TABLE `users` AUTO_INCREMENT =1');
        }
    }
}
