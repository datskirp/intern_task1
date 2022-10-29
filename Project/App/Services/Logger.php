<?php

namespace App\Services;

class Logger
{
    const LOG_DIR = ROOT . '/logs/';

    public static function writeLog(array $logInfo): void
    {
        $filename = 'upload_' . date('dmY') . '.log';
        if (!is_dir(self::LOG_DIR . $logInfo['status'])) {
            @mkdir(self::LOG_DIR . $logInfo['status'], 0744, true);
        }
        $fileToWrite = fopen(self::LOG_DIR . $logInfo['status'] . '/' . $filename, 'a');
        $now = date('d-m-Y H:i:s');
        if (is_array($logInfo['errors'])) {
            $logInfo['errors'] = self::expandErrorsForLogging($logInfo['errors']);
        }
        $message = sprintf(
            "%s => Upload status: %s. \nFile name: %s \nSize: %s \nErrors occured: %s\n\n",
                $now,
                $logInfo['status'],
                $logInfo['name'],
                $logInfo['size'],
                $logInfo['errors'],
        );
        fwrite($fileToWrite, $message);
        fclose($fileToWrite);
    }

    private static function expandErrorsForLogging(array $errors): string
    {
        $errorMsg = '';
        foreach ($errors as $type => $value) {
            $errorMsg .= $type . '=> ' . $value . ';';
        }

        return $errorMsg;
    }
}