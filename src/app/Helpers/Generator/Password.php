<?php

namespace App\Helpers\Generator;

/**
 * Class Password
 *
 * Password Generator
 *
 * @package App\Helpers\Generator
 */
class Password
{

    /**
     * @param int $length
     *
     * @return string
     */
    public static function generatePassword(int $length = 16): string
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $charsLength = strlen($chars) - 1;
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $charsLength);
            $pass[] = $chars[$n];
        }
        return implode($pass);

    }

}