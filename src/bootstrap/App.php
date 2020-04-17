<?php

use App\Core\Controller;
use Dotenv\Dotenv;
use Slim\App as Slim;
use Dopesong\Slim\Error\Whoops as WhoopsError;

// composer autoload
require_once __DIR__ . "/../vendor/autoload.php";

// custom autoload
require_once __DIR__ . "/../autoload.php";

// load config
Dotenv::createImmutable(__DIR__ . "/..")->load();

// slim app
$app = new Slim([
    'settings' => [
        'displayErrorDetails' => getenv("APP_DEBUG"),
        'determineRouteBeforeAppMiddleware' => true,
        'db' => [
            'driver' => getenv("DB_DRIVER"),
            'host' => getenv("DB_HOST"),
            'port' => getenv("DB_PORT"),
            'database' => getenv("DB_DATABASE"),
            'username' => getenv("DB_USERNAME"),
            'password' => getenv("DB_PASSWORD"),
            'charset' => getenv("DB_CHARSET")
        ]
    ]
]);

// get the container
$container = $app->getContainer();

// whoops error handling
if (getenv("APP_DEBUG") === 'true') {
    $container['phpErrorHandler'] = $container['errorHandler'] = function($c) {
        return new WhoopsError();
    };
}

// override the 404 handler
$container['notFoundHandler'] = function($container) {
    return function ($request, $response) use ($container) {
        $c = new Controller($container);
        return $c->error($response, 404, "Nothing here.");
    };
};

// twig
$container['view'] = function () {
    $view = new \Slim\Views\Twig(__DIR__ . "/../resources/views", [
        'cache' => getenv('VIEW_CACHE') === 'true' ? __DIR__ . "/../" . getenv('VIEW_CACHE_PATH') : false
    ]);
    return $view;
};

// database
require_once __DIR__ . "/Database.php";

// web routes
require_once __DIR__ . "/../routes/web.php";

// api routes
require_once __DIR__ . "/../routes/api.php";