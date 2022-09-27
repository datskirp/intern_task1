<?php

namespace App\Models;

use App\Db;

class UserModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Db();
    }

    public function addUserToDb(array $userData): bool
    {
        $sql = 'INSERT INTO `users` (`email`, `name`, `gender`, `status`) 
                     VALUES (:email, :name, :gender, :status)';
        return $this->db->insertRecord($sql, $userData);
    }

    public function editUserInDb()
    {

    }

    public function deleteUserFromDb(array $ids): bool
    {
        $sql = 'DELETE FROM `users` WHERE `id` IN (:ids)';
        return $this->db->deleteRecord($sql, $ids);
    }
    public function deleteUserAllFromDb(): bool
    {
        $sql = 'DELETE FROM `users`';
        return $this->db->deleteRecord($sql);
    }

    public function viewUserAllFromDb(): ?array
    {
        return $this->db->getAll();
    }
}