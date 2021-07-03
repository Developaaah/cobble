<?php

namespace App\Helpers\Generator;

/**
 * Class GUID
 *
 * GUID Generator
 *
 * @package App\Helpers\Generator
 */
class GUID
{

    /**
     * @return string
     */
    public static function generateGUID(): string
    {
        return sprintf("%04X%04X%04X%04X-%04X%04X-%04X%04X-%04X-%04X%04X%04X",
            mt_rand(0, 65535),
            mt_rand(0, 65535),
            mt_rand(0, 65535),
            mt_rand(0, 65535),
            mt_rand(0, 65535),
            mt_rand(0, 65535),
            mt_rand(0, 65535),
            mt_rand(0, 65535),
            mt_rand(0, 65535),
            mt_rand(0, 65535),
            mt_rand(0, 65535),
            mt_rand(0, 65535)
        );
    }

}