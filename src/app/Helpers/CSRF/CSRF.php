<?php

namespace App\Helpers\CSRF;

/**
 * Class CSRF
 *
 * CSRF Token Generator and Validator
 *
 * @package App\Helpers\CSRF
 */
class CSRF
{

    /**
     * @param string $string
     *
     * @return string
     * @throws \Exception
     */
    public static function createToken(string $string): string
    {
        $token = bin2hex(random_bytes(32));
        return hash_hmac("sha256", $string, $token);
    }

    /**
     * @param string $csrf
     * @param string $token
     *
     * @return bool
     */
    public static function validateToken(string $csrf, string $token): bool
    {
        if (hash_equals($token, $csrf)) {
            return true;
        }
        return false;
    }

}