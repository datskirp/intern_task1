<?php

namespace App;

class Alert
{
    private static string $msg = '';

    public static function setMsg(string $msg)
    {
       self::$msg = $msg;
    }

    public static function getAlertMsg()
    {
        return self::$msg;
    }

    public static function resetMsg()
    {
        self::$msg = '';
    }
}
