<?php

namespace App\Helpers;

class Allstars
{
    public static function encrypt($string)
    {
        $key = hash('sha256', config('hashing.secret_key'));
        $iv = substr(hash('sha256', config('hashing.secret_hash')), 0, 16);
        $result = openssl_encrypt($string, 'AES-256-CBC', $key, 0, $iv);
        return $result = base64_encode($result);
    }

    public static function decrypt($string)
    {
        $key = hash('sha256', config('hashing.secret_key'));
        $iv = substr(hash('sha256', config('hashing.secret_hash')), 0, 16);
        return openssl_decrypt(base64_decode($string), 'AES-256-CBC', $key, 0, $iv);
    }
}
