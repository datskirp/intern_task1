<?php

namespace App\Models\User;

use App\Db;
use App\Validator\UserValidator;

abstract class Base
{
    protected int $id;
    protected $db;
    protected $validator;

    public function __construct(Db $db, UserValidator $validator)
    {
        $this->db = $db;
        $this->validator = $validator;
    }


    public function getId(): int
    {
        return $this->id;
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
        var_dump(static::getTableName());
        var_dump($this->db);
        return $this->db->query('SELECT * FROM `' . static::getTableName() . '`;', [], static::class);
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

    public function delete(int $id = null): void
    {
        if (is_null($id)) {
            $id = $this->id;
        }
        self::$db->query(
            'DELETE FROM `' . static::getTableName() . '` WHERE id = :id',
            [':id' => $id]
        );
        $this->id = null;
    }

    public function save(): void
    {
        $mappedProperties = $this->mapPropertiesToDbFormat();
        if ($this->id !== null) {
            $this->update($mappedProperties);
        } else {
            $this->insert($mappedProperties);
        }
    }

    public static function checkEmailExistence($email): bool
    {
        $result = self::$db->query(
            'SELECT * FROM `' . static::getTableName() . '` WHERE `email` = :email',
            ['email' => $email]
        );
        if (!is_null($result)) {
            return true;
        }
        return false;
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

    private function update(array $mappedProperties): void
    {
        $columns2params = [];
        $params2values = [];
        $index = 1;
        foreach ($mappedProperties as $column => $value) {
            $param = ':param' . $index; // :param1
            $columns2params[] = $column . ' = ' . $param; // column1 = :param1
            $params2values[$param] = $value; // [:param1 => value1]
            $index++;
        }
        $sql = 'UPDATE ' . static::getTableName() . ' SET ' . implode(', ', $columns2params) . ' WHERE id = ' . $this->id;
        $db = Db::getInstance();
        $db->query($sql, $params2values, static::class);
    }

    protected function insert(array $data): ?array
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

        return self::$db->query($sql, $data, static::class);
    }

    private function refresh(): void
    {
        $objectFromDb = static::getById($this->id);
        $reflector = new \ReflectionObject($objectFromDb);
        $properties = $reflector->getProperties();

        foreach ($properties as $property) {
            $property->setAccessible(true);
            $propertyName = $property->getName();
            $this->$propertyName = $property->getValue($objectFromDb);
        }
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
