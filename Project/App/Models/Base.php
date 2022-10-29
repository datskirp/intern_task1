<?php

namespace App\Models;

use App\Services\Db;

abstract class Base
{
    protected static $db;

    public function __construct()
    {
        self::$db = Db::getInstance();
    }

    abstract protected static function getTableName(): string;

    public function getAll(): ?array
    {
        return self::$db->query('SELECT * FROM `' . static::getTableName() . '`;');
    }

    public static function getById(int $id): ?array
    {
        $entities = self::$db->query(
            'SELECT * FROM `' . static::getTableName() . '` WHERE id=:id;',
            [':id' => $id],
        );

        return $entities ? $entities[0] : null;
    }

    public function deleteByID(int $id): bool
    {
        if (is_null(self::getById($id))) {
            return false;
        }
        return self::$db->changeRecord(
            'DELETE FROM `' . static::getTableName() . '` WHERE id = :id',
            [':id' => $id]
        );
    }

    public static function isRecord(string $columnName, mixed $value, string $className = ''): array|false
    {
        return self::$db->getRecord(
            'SELECT * FROM `' . static::getTableName() . '` WHERE `' . $columnName . '` = :value',
            ['value' => $value], $className
        );
    }

    public function getColumnById(int $id, $column): array|false
    {
        $result = self::$db->getRecord(
            'SELECT '. $column . ' FROM `' . static::getTableName() . '` WHERE `id` = :id',
            [':id' => $id]
        );

        return $result ?: false;
    }

    public function update(array $data): bool
    {
        $columnParams = [];
        $paramsValues = [];
        $index = 1;
        foreach ($data as $column => $value) {
            $param = ':param' . $index; // :param1
            $columnParams[] = $column . ' = ' . $param; // column1 = :param1
            $paramsValues[$param] = $value; // [:param1 => value1]
            $index++;
        }
        $sql = 'UPDATE ' . static::getTableName() . ' SET ' . implode(', ', $columnParams) . ' WHERE id = ' . $data['id'];

        return self::$db->changeRecord($sql, $paramsValues);
    }

    public function insert(array $data): bool
    {
        $columns = [];
        $paramsNames = [];
        foreach ($data as $columnName => $value) {
            $columns[] = '`' . $columnName. '`';
            $paramName = ':' . $columnName;
            $paramsNames[] = $paramName;
        }

        $columnsViaSemicolon = implode(', ', $columns);
        $paramsNamesViaSemicolon = implode(', ', $paramsNames);

        $sql = 'INSERT INTO ' . static::getTableName() . ' (' . $columnsViaSemicolon . ') VALUES (' . $paramsNamesViaSemicolon . ');';

        return self::$db->changeRecord($sql, $data);
    }
}
