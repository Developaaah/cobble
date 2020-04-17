<?php

/**
 * Recursive Autoloader
 *
 * @package Autoloader
 * @license MIT License
 * @author Dennis Schuster <hi@dennisschuster.net>
 */
class Autoload {

    /**
     * @var string
     */
    private static $file_ext = '.php';


    /**
     * @var string
     */
    private static $pathTop = __DIR__;


    /**
     * @var null
     */
    private static $fileIterator = null;


    /**
     * Autoloads all Classes in the "/app" directory
     *
     * @param $className
     */
    public static function load($className) {
        $directory = new RecursiveDirectoryIterator(static::$pathTop, RecursiveDirectoryIterator::SKIP_DOTS);

        if (is_null(static::$fileIterator)) {
            static::$fileIterator = new RecursiveIteratorIterator($directory, RecursiveIteratorIterator::LEAVES_ONLY);
        }

        $filename = $className . static::$file_ext;

        foreach (static::$fileIterator as $file) {
            if (strtolower($file->getFilename()) === strtolower($filename)) {
                if ($file->isReadable()) {
                    include_once $file->getPathname();
                }
                break;
            }
        }

    }

}

spl_autoload_register("Autoload::load");
