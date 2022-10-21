<?php

namespace App\Models\User;

use App\Db;
use App\Validator\UserValidator;

abstract class Base
{
    protected static $db;
    protected $validator;

    public function __construct()
    {
        self::$db = Db::getInstance();
    }


    public function __set(string $name, $value)
    {
        $camelCaseName = $this->underscoreToCamelCase($name);
        $this->$camelCaseName = $value;
    }

    private function underscoreToCamelCase(string $source): string
    {
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }

    public function getAll(): ?array
    {
        return self::$db->query('SELECT * FROM `' . static::getTableName() . '`;', [], static::class);
    }

    public static function getById(int $id): ?self
    {
        $entities = self::$db->query(
            'SELECT * FROM `' . static::getTableName() . '` WHERE id=:id;',
            [':id' => $id],
            static::class
        );
        return $entities ? $entities[0] : null;
    }

    public function delete(int $id): bool
    {
        return self::$db->changeRecord(
            'DELETE FROM `' . static::getTableName() . '` WHERE id = :id',
            [':id' => $id]
        );
    }

    public static function checkEmailExistence($email): array|false
    {
        return self::$db->getRecord(
            'SELECT * FROM `' . static::getTableName() . '` WHERE `email` = :email',
            ['email' => $email]
        );
    }

    public static function getEmailById(int $id): array|false
    {
        $result = self::$db->getRecord(
            'SELECT `email` FROM `' . static::getTableName() . '` WHERE `id` = :id',
            [':id' => $id]
        );
        return $result ? : false;
    }


    abstract protected static function getTableName(): string;

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


    private function mapPropertiesToDbFormat(): array
    {
        $reflector = new \ReflectionObject($this);
        $properties = $reflector->getProperties();

        $mappedProperties = [];
        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $propertyNameAsUnderscore = $this->camelCaseToUnderscore($propertyName);
            $mappedProperties[$propertyNameAsUnderscore] = $this->$propertyName;
        }

        return $mappedProperties;
    }

    private function camelCaseToUnderscore(string $source): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $source));
    }



    public function add(array $userData): ?array
    {
        $sql = 'INSERT INTO ' . static::getTableName() . ' (`id`, `email`, `name`, `gender`, `status`) 
                     VALUES (:id, :email, :name, :gender, :status)';

        return $this->db->changeRecord($sql, $userData) ? $userData : null;
    }



    public function edit(array $userData): ?array
    {
        $db = Db::getInstance();
        if ($db->getEmailById((int)$userData['id']) === $userData['email']) {
            $sql = 'UPDATE `users` SET `name` = :name, 
                   `gender` = :gender, `status` = :status WHERE id = :id';

            return $this->db->changeRecord($sql, $userData) ? $userData : null;
        } else {
            $sql = 'UPDATE `users` SET `email` = :email, `name` = :name, 
                   `gender` = :gender, `status` = :status WHERE id = :id';

            return $this->db->changeRecord($sql, $userData) ? $userData : null;
        }
    }





}
