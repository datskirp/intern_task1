<?php

namespace App\Validator;

class Validator implements ValidatorInterface
{
    private bool $isValid;
    private array $errorMsg = [];
    private bool $fileTypeChecked = false;

    public function validate(array $file, array $rules): void
    {
        foreach ($rules as $fileField => $constraintList) {
            foreach ($constraintList as $constraint) {
                if ($this->fileTypeChecked) {
                    break;
                }
                if ($this->$constraint($file[$fileField])) {
                    break;
                }
            }
        }
        if ($this->fileTypeChecked) {
            unset($this->errorMsg['type']);
        }
        empty($this->errorMsg) ? $this->isValid = true : $this->isValid = false;
    }

    private function image(string $tmpFileName): bool
    {
        $finfo = finfo_open(FILEINFO_MIME);
        $mimetype = finfo_file($finfo, $tmpFileName);
        if (str_contains($mimetype, 'image')) {
            $this->fileTypeChecked = true;

            return true;
        }
        $this->errorMsg['type'] = 'File is not an image or a text file';

        return false;
    }

    private function txt(string $fileName): bool
    {
        if (pathinfo($fileName, PATHINFO_EXTENSION) === 'txt') {
            $this->fileTypeChecked = true;

            return true;
        }
        $this->errorMsg['type'] = 'File is not an image or a text file';

        return false;
    }

    private function localStorage(int $fileSize): bool
    {
        if (diskfreespace(__DIR__ . '/../../www') - $fileSize > 0) {
            return true;
        }
        $this->errorMsg['diskSpace'] = 'Not enough disk space to save a file';

        return false;
    }

    public static function uploadDirExists()
    {
        return is_dir(__DIR__ . '/../../www/uploads');
    }

    public function getErrors(): array
    {
        return $this->errorMsg;
    }

    public function isValid()
    {
        return $this->isValid;
    }
}
