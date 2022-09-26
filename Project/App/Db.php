<?php

namespace DbServices;

class Db
{
    private $pdo;

    public function __construct()
    {
        $dbInit = (require __DIR__ . '/../DbSettings.php')['db'];

        $this->pdo = new \PDO(
            'mysql:host=' . $dbInit['host'] . ';dbname=' . $dbInit['dbname'],
            $dbInit['user'],
            $dbInit['password']
        );
        $this->pdo->exec('SET NAMES UTF8');
    }
    public function query(string $sql, $params = []): ?array
    {
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($params);

        if (false === $result) {
            return null;
        }

        return $sth->fetchAll();
    }
}