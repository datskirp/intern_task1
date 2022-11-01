<?php

namespace App\Services;

class Db
{
    private static $instance;
    private object $pdo;

    public function __construct()
    {
        $dbInit = (require ROOT . '/Config/db.php')['db'];

        $dsn = 'mysql:host=' . $dbInit['host'] . '; dbname=' . $dbInit['dbname'] .
            '; port=' . $dbInit['port'];
        $this->pdo = new \PDO(
            $dsn,
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
    public function query(string $sql, array $params = []): ?array
    {
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($params);
        if ($result === false) {
            return null;
        }

        return $sth->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function changeRecord(string $sql, array $values): bool
    {
        $sth = $this->pdo->prepare($sql);

        return $sth->execute($values);
    }

    public function getRecord(string $sql, array $values = [], string $className = ''): array|false
    {
        $sth = $this->pdo->prepare($sql);
        $sth->execute($values);
        if ($className) {
            return $sth->fetchAll(\PDO::FETCH_CLASS, $className);
        }
        return $sth->fetch(\PDO::FETCH_ASSOC);
    }
}
