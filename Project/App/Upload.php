<?php

namespace App;

class Upload
{
    private $validator;
    private $view;
    private $validatorRules;

    public function __construct(Validator\Validator $validator, View $view, $validatorRules)
    {
        $this->validator = $validator;
        $this->view = $view;
        $this->validatorRules = $validatorRules;
    }

    public function index()
    {
        return $this->view->renderHtml('Upload.html.twig');
    }

    public function upload(?array $file, string $formName)
    {
        if (is_null($file) || $file[$formName]['error'] === UPLOAD_ERR_NO_FILE) {
            return $this->view->render400('400.html.twig');
        }
        $uploadsDir = __DIR__ . '/../www/uploads/';
        $this->validator->validate($file[$formName], $this->validatorRules);
        if ($this->validator->isValid()) {
            $this->createUploadsDir($uploadsDir);
            move_uploaded_file($file[$formName]['tmp_name'], $uploadsDir . $file[$formName]['name']);
            self::writeLog(
                [
                    'status' => 'success',
                    'name' => $file[$formName]['name'],
                    'size' => $file[$formName]['size'],
                    'errors' => 'none',
                ]
            );

            return $this->view->renderHtml(
                'Upload.html.twig',
                [
                    'files' => $this->createUploadsDirInfo($uploadsDir),
                    'tableId' => 'files',
                ]
            );
        } else {
            self::writeLog(
                [
                    'status' => 'failure',
                    'name' => $file[$formName]['name'],
                    'size' => $file[$formName]['size'],
                    'errors' => $this->validator->getErrors(),
                ]
            );

            return $this->view->renderHtml(
                'Uploads.html.twig',
                [
                    'errors' => $this->validator->getErrors(),
                    'files' => $this->createUploadsDirInfo($uploadsDir),
                    'tableId' => 'files',
                ]
            );
        }
    }

    public function createUploadsDir($uploadsDir)
    {
        if (!$this->validator::uploadDirExists()) {
            @mkdir($uploadsDir, 0744);
        }
    }

    public function createUploadsDirInfo($uploadsDir)
    {
        if ($dh = opendir($uploadsDir)) {
            $filesInfo = [];
            while (($file = readdir($dh)) !== false) {
                if (is_dir($file)) {
                    continue;
                }
                $filesInfo[$file]['size'] = ceil(filesize($uploadsDir . $file) / 1000);
                $mimetype = mime_content_type($uploadsDir . $file);
                $filesInfo[$file]['meta'] = str_contains($mimetype, 'image') ? $mimetype : '';
            }
            closedir($dh);
        }

        return $filesInfo;
    }

    private static function writeLog(array $logInfo)
    {
        $filename = 'upload_' . date('dmY') . '.log';
        $fileToWrite = fopen(__DIR__ . '/../logs/' . $filename, 'a');
        $now = date('d-m-Y H:i:s');

        $message = sprintf(
            "%s => Upload status: %s. \nFile name: %s \nSize: %s \nErrors occured: %s\n\n",
            $now,
            $logInfo['status'],
            $logInfo['name'],
            $logInfo['size'],
            $logInfo['errors']
        );
        fwrite($fileToWrite, $message);
        fclose($fileToWrite);
    }
}
