<?php
namespace App\Libraries;

class Hash
{
    public static function make($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public static function passwordVerify($password, $hash)
    {
        return password_verify($password, $hash);
    }
}