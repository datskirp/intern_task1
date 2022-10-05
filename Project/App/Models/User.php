<?php

namespace App\Models;

class User extends Base
{
    public function add(array $userData): ?array
    {
        $sql = 'INSERT INTO `users` (`id`, `email`, `name`, `gender`, `status`) 
                     VALUES (:id, :email, :name, :gender, :status)';
        return $this->db->changeRecord($sql, $userData) ? $userData : null;
    }

    public function show(int $id): array|false
    {
        $sql = 'SELECT * FROM users WHERE id = :id';
        return $this->db->getRecord($sql, ['id' => $id]);
    }

    public function edit(array $userData): ?array
    {
        $sql = 'UPDATE `users` SET `email` = :email, `name` = :name, 
                   `gender` = :gender, `status` = :status WHERE id = :id';
        return $this->db->changeRecord($sql, $userData) ? $userData : null;
    }

    public function delete(int $id): bool
    {
        $sql = 'DELETE FROM `users` WHERE `id` = :id';
        return $this->db->deleteRecord($sql, $id);
    }

    public function getAll(): ?array
    {
        return $this->db->getAll();
    }
}