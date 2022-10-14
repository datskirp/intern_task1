<?php

namespace App\Validator;

use App\Alert;

abstract class Base
{
    public Alert $alert;

    public function __construct()
    {
        $this->alert = new Alert();
    }
    //$inputField = ['email' => $value] or ['name' => $value]
    public function validate(array $inputFields, array $rules): bool
    {
    }
}
