<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Crypt;

class MainHelper 
{
    public static function encrypt($string)
    {
        $encrypted = Crypt::encryptString($string);
        return $encrypted;
    }

    public static function decrypt($string)
    {
        $encrypted = Crypt::decryptString($string);
        return $encrypted;
    }
}