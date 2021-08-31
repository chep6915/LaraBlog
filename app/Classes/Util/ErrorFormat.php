<?php



namespace App\Classes\Util;


class ErrorFormat
{

    public static function exceptionToString(\Exception $e): string
    {
        return $e->getMessage() . " at [" . $e->getFile() . ":" . $e->getLine() . "]";
    }
}
