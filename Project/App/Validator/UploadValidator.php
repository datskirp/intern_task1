<?php

namespace App\Validator;

use App\Controllers\Upload\UploadController;

class UploadValidator extends Base
{
    private array $rules;

    public function __construct()
    {
        $this->rules = [
            'mimetype' => 'image | txt',
            'size' => 'enoughLocalStorage | maxSize: ' . UploadController::MAX_FILE_SIZE,
        ];
    }

    public function validate(array $inputFields): bool
    {
        $this->validateData($inputFields, $this->rules);

        return empty($this->errors);
    }
}
