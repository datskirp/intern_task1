<?php

namespace App\Models;

use App\Db;

abstract class Base
{
    protected Db $db;

    public function __construct()
    {
        $this->db = new Db();
    }
}
