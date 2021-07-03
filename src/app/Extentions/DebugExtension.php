<?php

namespace App\Extentions;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class DebugExtension
 * @package App\View
 */
class DebugExtension extends AbstractExtension
{

    /**
     * @return TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction("dumper", [$this, 'dump'])
        ];
    }

    /**
     * @param $var
     *
     * @return array|mixed
     */
    public function dump($var)
    {
        if ($_ENV['APP_DEBUG'] === 'true') {
            return dump($var);
        }
        return "";
    }

}