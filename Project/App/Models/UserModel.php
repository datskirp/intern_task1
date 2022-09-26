<?php

namespace App\Models;

use App\Db;

class UserModel
{
    public $db;

    public function __construct()
    {
        $this->db = new Db();
    }
    public function addUserToDb(array $userData): bool
    {
        echo "inside addusertodb";
        $sql = sprintf('INSERT INTO users VALUES (%s, %s, %s, %s)',
                        $userData['email'], $userData['name'], $userData['gender'], $userData['status']
                    );
        return $this->db->insertRecord($sql);
    }

    public function editUserInDb()
    {

    }

    public function deleteUserFromDb()
    {

    }

    public function viewUserAllFromDb()
    {

    }
}