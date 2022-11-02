<?php

namespace App\Services;

use function DI\string;

class Db
{
    private static $instance;
    private object $pdo;
    private string $sql = '';
    private array $execute = [];

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

    private function clear()
    {
        $this->sql = '';
        $this->execute = [];
    }

    public function from(string $table): self
    {
        $this->sql .= ' FROM `' . $table . '` ';

        return $this;
    }

    public function update(string $table): self
    {
        $this->sql .= 'UPDATE ' . $table;

        return $this;
    }

    public function set(array $values): self
    {
        $sql = ' SET ';
        foreach ($values as $key => $value) {

            if (filter_var($value, FILTER_VALIDATE_IP)) {
                $sql .= '`' . $key . '` = '. sprintf('INET_ATON(`:%s`), ', $key);
                $this->execute[':' . $key] = $value;
                continue;
            }
            $sql .= '`' . $key . '` = :' . $key . ', ';
            $this->execute[':' . $key] = $value;
        }
        $this->sql .= rtrim($sql, ', ');

        return $this;
    }

    public function insert($table): self
    {
        $this->sql .= 'INSERT INTO `' . $table . '`';
        return $this;
    }

    public function delete(string $table): self
    {
        $this->sql .= 'DELETE FROM `' . $table . '`';
        return $this;
    }

    public function columns(array $columns): self
    {
        $sql = ' (';
        foreach ($columns as $column) {

            $sql .= '`' . $column . '`, ';
        }
        $sql = rtrim($sql, ', ');
        $sql .= ')';
        $this->sql .= $sql;

        return $this;

    }

    public function values(array $values): self
    {
        $sql = ' VALUES (';
        foreach ($values as $key => $value) {

            if (filter_var($value, FILTER_VALIDATE_IP)) {
                $sql .= sprintf('INET_ATON(:%s), ', $key);
                $this->execute[':' . $key] = $value;
                continue;
            }
            $sql .= ':' . $key . ', ';
            $this->execute[':' . $key] = $value;
        }
        $this->sql .= rtrim($sql, ', ') . ')';

        return $this;
    }

    public function select(array $columns = ['*']): self
    {
        $select = '';
        foreach ($columns as $column) {
            if ($column === '*') {
                $select = $column;

                break;
            }
            if (filter_var($column, FILTER_VALIDATE_IP)) {
                $select .= sprintf('INET_NTON(`:%s`), ', $column);
                $this->execute[':' . $column] = $column;
                continue;
            }
            $select .= '`' . $column . '`, ';
            $this->execute[':' . $column] = $column;
        }
        $this->sql = 'SELECT ' . rtrim($select, ', ');

        return $this;
    }

    public function limit(int $limit): self
    {
        $this->sql .= ' LIMIT ' . $limit;
        return $this;
    }

    public function and(array $condition, string $operator = '='): self
    {
        if (filter_var($condition[key($condition)], FILTER_VALIDATE_IP)) {
            $this->sql .= ' AND `' . key($condition) . '` ' . rtrim($operator, ':') . ' ' . sprintf('INET_ATON(:%s)', key($condition));
            $this->execute[':' . key($condition)] = $condition[key($condition)];

            return $this;
        }

        if (str_contains($operator, ':')) {
            $this->sql .= ' AND `' . key($condition) . '` ' . $operator . key($condition);
            $this->execute[':' . key($condition)] = $condition[key($condition)];
            return $this;
        }
        $this->sql .= ' AND `' . key($condition) . '` ' . $operator . ' ' . $condition[key($condition)];

        return $this;
    }

    public function do(): bool
    {
        $sth = $this->pdo->prepare($this->sql);
        $result = $sth->execute($this->execute);
        $this->clear();
        return $result;
    }

    public function get(): ?array
    {
        $sth = $this->pdo->prepare($this->sql);
        $result = $sth->execute($this->execute);
        $this->clear();
        if ($result === false) {
            return null;
        }

        return $sth->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getOne(): array|false
    {
        $sth = $this->pdo->prepare($this->sql);
        $sth->execute($this->execute);
        $this->clear();

        return $sth->fetch(\PDO::FETCH_ASSOC);
    }

    public function where(array $condition, string $operator = '='): self
    {
        if (filter_var($condition[key($condition)], FILTER_VALIDATE_IP)) {
            $this->sql .= ' WHERE `' . key($condition) . '` ' . rtrim($operator, ':') . ' ' . sprintf('INET_ATON(:%s)', key($condition));
            $this->execute[':' . key($condition)] = $condition[key($condition)];

            return $this;
        }


        if (str_contains($operator, ':')) {
            $this->sql .= ' WHERE `' . key($condition) . '` ' . $operator . key($condition);
            $this->execute[':' . key($condition)] = $condition[key($condition)];
            return $this;
        }
        $this->sql .= ' WHERE `' . key($condition) . '` ' . $operator . ' ' . $condition[key($condition)];

        return $this;
    }

    public function join(string  $table, string $column): self
    {
        $this->sql .= ' INNER JOIN ' . $table . ' USING (' . $column . ')';
        return $this;
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

    public function getOneObject(string $className): array|false
    {
        $sth = $this->pdo->prepare($this->sql);
        $sth->execute($this->execute);
        $this->clear();
        return $sth->fetch(\PDO::FETCH_CLASS, $className);
    }

    public function getRecord(string $sql, array $values, string $className = ''): array|false
    {
        $sth = $this->pdo->prepare($sql);
        $sth->execute($values);
        if ($className) {
            return $sth->fetchAll(\PDO::FETCH_CLASS, $className);
        }

        return $sth->fetch(\PDO::FETCH_ASSOC);
    }
}
