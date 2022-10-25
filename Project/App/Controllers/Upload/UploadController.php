<?php
namespace App\Controllers\Upload;

use App\Controllers\BaseController;
use App\Validator\UploadValidator;
use App\Logger;

class UploadController extends BaseController
{
    const MAX_FILE_SIZE = 1 * 1024 * 1024;
    const FORM_NAME = 'upload';
    const UPLOAD_DIR = ROOT . '/www/uploads/';
    private $validator;

    public function index(): string
    {
        if (is_dir(self::UPLOAD_DIR)) {
            return $this->view->render(
                'Upload.twig',
                [
                    'files' => $this->createUploadsDirInfo(self::UPLOAD_DIR),
                    'tableId' => 'files',
                    'maxSize' => self::MAX_FILE_SIZE,
                ]
            );
        }

        return $this->view->render('Upload.twig', ['maxSize' => self::MAX_FILE_SIZE]);
    }

    public function upload(array $args = []): string
    {
        $file = $_FILES;
        $formName = self::FORM_NAME;
        if (is_null($file) || $file[$formName]['error'] === UPLOAD_ERR_NO_FILE) {
            Logger::writeLog(
                [
                    'status' => 'failure',
                    'name' => $file[$formName]['name'],
                    'size' => $file[$formName]['size'],
                    'errors' => 'No file was uploaded',
                ]);
            return $this->view->renderError(400, 'No file was uploaded');
        }
        if ($this->validator->validate($file[$formName])) {
            $this->createUploadsDir(self::UPLOAD_DIR);
            move_uploaded_file($file[$formName]['tmp_name'], self::UPLOAD_DIR . $file[$formName]['name']);
            Logger::writeLog(
                [
                    'status' => 'success',
                    'name' => $file[$formName]['name'],
                    'size' => $file[$formName]['size'],
                    'errors' => 'none',
                ]
            );

            return $this->view->render(
                'Upload.twig',
                [
                    'files' => $this->createUploadsDirInfo(self::UPLOAD_DIR),
                    'tableId' => 'files',
                ]
            );
        } else {
            Logger::writeLog(
                [
                    'status' => 'failure',
                    'name' => $file[$formName]['name'],
                    'size' => $file[$formName]['size'],
                    'errors' => $this->validator->getErrors(),
                ]
            );

            return is_dir(self::UPLOAD_DIR) ?
                $this->view->render(
                    'Upload.twig',
                    [
                        'errors' => $this->validator->getErrors(),
                        'files' => $this->createUploadsDirInfo(self::UPLOAD_DIR),
                        'tableId' => 'files',
                    ]
                ) :
                $this->view->render(
                    'Upload.twig',
                    [
                        'errors' => $this->validator->getErrors(),
                    ]
                );
        }
    }

    public function createUploadsDir($uploadsDir): void
    {
        if (!is_dir($uploadsDir)) {
            @mkdir($uploadsDir, 0744);
        }
    }

    public function createUploadsDirInfo($uploadsDir): array
    {
        if ($dh = opendir($uploadsDir)) {
            $filesInfo = [];
            while (($file = readdir($dh)) !== false) {
                if (is_dir($file)) {
                    continue;
                }
                $filesInfo[$file]['size'] = ceil(filesize($uploadsDir . $file) / 1024);
                $mimetype = mime_content_type($uploadsDir . $file);
                $filesInfo[$file]['meta'] = str_contains($mimetype, 'image') ? $mimetype : '';
            }
            closedir($dh);
        }

        return $filesInfo;
    }


    public function setUploadValidator(UploadValidator $uploadValidator)
    {
        $this->validator = $uploadValidator;
    }
}