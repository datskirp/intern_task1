<?php

namespace App\Models\User;

use App\Db;

abstract class Base
{
    protected Db $db;

    public function __construct()
    {
        $this->db = new Db();
    }
}
