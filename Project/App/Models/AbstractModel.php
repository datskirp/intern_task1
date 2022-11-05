<?php

namespace App\Models;

use App\Models\User\User;
use App\Services\Db;

abstract class AbstractModel
{
    protected static $db;

    public function __construct()
    {
        self::$db = Db::getInstance();
    }

    abstract protected static function getTableName(): string;

    public function getAll(): ?array
    {
        return self::$db->select()
            ->from(static::getTableName())
            ->get();
    }

    public function getAllObject(): ?array
    {
        return self::$db->select()
            ->from(static::getTableName())
            ->getAllObject(static::class);
        /*
        return self::$db->getRecord('SELECT * FROM `' . static::getTableName() . '`;', [], static::class);
        */
    }

    public static function getById(int $id): ?array
    {
        return self::$db->select()
            ->from(static::getTableName())
            ->where(['id' => $id], '= :')
            ->getOne() ? : null;
    }

    public static function getByIdObject(int $id)
    {
        return self::$db->select()
            ->from(static::getTableName())
            ->where(['id' => $id], '= :')
            ->getOneObject(static::class);
        /*
        $entities = self::$db->getRecord(
            'SELECT * FROM `' . static::getTableName() . '` WHERE id=:id;',
            [':id' => $id], static::class
        );

        return $entities ? $entities[0] : null;
        */
    }

    public function deleteByID(int $id): bool
    {
        if (is_null(self::getById($id))) {
            return false;
        }

        return self::$db->delete(static::getTableName())
            ->where(['id' => $id], '= :')
            ->do();
    }

    public static function isRecord(string $columnName, mixed $value): array|false
    {
        return self::$db->select()
            ->from(static::getTableName())
            ->where([$columnName => $value], '= :')
            ->getOne();
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
