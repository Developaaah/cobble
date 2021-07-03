<?php

namespace App\Helpers\Language;

use Slim\Http\Cookies;

/**
 * Class Language
 * @package App\Helpers\Language
 */
class Language
{

    /**
     * @param string $lang
     *
     * @return array
     */
    public static function getLang(string $lang): array
    {
        $path = __DIR__ . "/../../../translations/lang." . $lang . ".json";
        return json_decode(file_get_contents($path), true);
    }

    /**
     * @param string $lang
     */
    public static function setSessionLang(string $lang): void
    {
        $_SESSION['lang'] = $lang;
    }

    /**
     * @param string $lang
     *
     * @return Cookies
     */
    public static function setCookieLang(string $lang): Cookies
    {
        $cookies = new Cookies();
        $cookies->set("lang", [
            "value" => $lang,
            "expires" => time() + (86400 * 30),
            "path" => "/",
            "domain" => $_ENV['APP_URL'],
            "secure" => true
        ]);
        return $cookies;
    }

}