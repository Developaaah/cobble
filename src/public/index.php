<?php

session_start();

// turn error reporting on
error_reporting(E_ALL);

use Bootstrap\App;
use Dotenv\Dotenv;
use Slim\App as Slim;

// require the composer autoloader
require_once __DIR__ . "/../vendor/autoload.php";

// Load the .env file into $_ENV (usable everywhere)
Dotenv::createImmutable(__DIR__ . "/..")->load();

// create a new slim application
$slim = new Slim([
    'settings' => [
        'displayErrorDetails' => $_ENV["APP_DEBUG"],
        'determineRouteBeforeAppMiddleware' => true,
        'db' => [
            'driver' => $_ENV["DB_CONNECTION"],
            'host' => $_ENV["DB_HOST"],
            'port' => $_ENV["DB_PORT"],
            'database' => $_ENV["DB_DATABASE"],
            'username' => $_ENV["DB_USERNAME"],
            'password' => $_ENV["DB_PASSWORD"],
            'charset' => $_ENV["DB_CHARSET"]
        ]
    ]
]);

// build the app
$app = App::build($slim);

$app->run();