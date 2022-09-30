<?php

namespace App\Models;

use App\Db;

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Db();
    }

    public function add(array $userData): bool
    {
        $sql = 'INSERT INTO `users` (`id`, `email`, `name`, `gender`, `status`) 
                     VALUES (:id, :email, :name, :gender, :status)';
        return $this->db->changeRecord($sql, $userData);
    }

    public function getUserInfo(string $id): array
    {
        $sql = 'SELECT * FROM users WHERE id = :id';
        return $this->db->getRecord($sql, ['id' => (int) $id]);
    }

    public function edit(array $userData): bool
    {
        $sql = 'UPDATE `users` SET `email` = :email, `name` = :name, 
                   `gender` = :gender, `status` = :status WHERE id = :id';
        return $this->db->changeRecord($sql, $userData);
    }

    public function delete(string $id): bool
    {
        $sql = 'DELETE FROM `users` WHERE `id` = :id';
        return $this->db->deleteRecord($sql, (int) $id);
    }

    public function getAll(): ?array
    {
        return $this->db->getAll();
    }
}