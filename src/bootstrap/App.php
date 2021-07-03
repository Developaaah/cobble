<?php

namespace Bootstrap;

use App\Core\Controller;
use App\Extentions\DebugExtension;
use App\Middleware\ClickjackingMiddlware;
use App\Middleware\Language\CookieMiddleware;
use App\Middleware\Language\SessionMiddleware;
use Dopesong\Slim\Error\Whoops;
use Illuminate\Database\Capsule\Manager;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Class App
 * @package Bootstrap
 */
class App
{

    /**
     * @param \Slim\App $app
     *
     * @return \Slim\App
     */
    public static function build(\Slim\App $app): \Slim\App
    {
        $container = $app->getContainer();
        if ($_ENV['APP_DEBUG'] === "true" && $_ENV['APP_ENV'] === "development") {
            $container = App::addErrorHandler($container);
        }
        $container = self::addNotFoundHandler($container);
        $container = self::addTwigViews($container);
        $container = self::addDatabaseConnection($container);
        self::addVarDumper();
        self::addMiddlewares($app);
        $app = self::registerWebRoutes($app);

        if (isset($_ENV['API_ENABLED']) && $_ENV['API_ENABLED'] === 'true') {
            $app = App::registerApiRoutes($app);
        }

        return $app;
    }

    /**
     * Adds all the global middlewares
     *
     * @param \Slim\App $app
     */
    public static function addMiddlewares(\Slim\App $app): void
    {
        $app->add(new ClickjackingMiddlware());

        if (isset($_ENV['LANG_MULTI']) && $_ENV['LANG_MULTI'] === "true") {
            $langs = explode(",", $_ENV['LANG_AVAILIBLE']);
            $type = $_ENV['LANG_TYPE'];
            if ($type == "cookie") {
                $app->add(new CookieMiddleware($_ENV['LANG_DEFAULT'], $langs));
            }
            else {
                $app->add(new SessionMiddleware($_ENV['LANG_DEFAULT'], $langs));
            }
        }
    }

    /**
     * @param ContainerInterface $container
     *
     * @return ContainerInterface
     */
    public static function addErrorHandler(ContainerInterface $container): ContainerInterface
    {
        $container["phpErrorHandler"] = $container["errorHandler"] = function ($c) {
            return new Whoops();
        };
        return $container;
    }

    /**
     * @param ContainerInterface $container
     *
     * @return ContainerInterface
     */
    public static function addNotFoundHandler(ContainerInterface $container): ContainerInterface
    {
        $container["notFoundHandler"] = function ($container) {
            return function (RequestInterface $request, ResponseInterface $response) use ($container) {
                $c = new Controller($container);
                return $c->notFound($response);
            };
        };
        return $container;
    }


    /**
     * @param ContainerInterface $container
     *
     * @return ContainerInterface
     */
    public static function addDatabaseConnection(ContainerInterface $container): ContainerInterface
    {
        $capsule = new Manager();
        $capsule->addConnection($container['settings']['db']);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        $container['db'] = function ($container) use ($capsule) {
            return $capsule;
        };
        return $container;
    }

    /**
     * @param ContainerInterface $container
     *
     * @return ContainerInterface
     */
    public static function addTwigViews(ContainerInterface $container): ContainerInterface
    {
        $container['view'] = function ($container) {
            $view = new Twig(__DIR__ . "/../views", [
                'cache' => $_ENV['VIEW_CACHE'] === 'true' ? __DIR__ . $_ENV['VIEW_CACHE_PATH'] : false,
                'debug' => $_ENV['APP_DEBUG'] === 'true'
            ]);

            $router = $container->get('router');
            $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
            $view->addExtension(new TwigExtension($router, $uri));
            $view->addExtension(new DebugExtension());

            return $view;
        };
        return $container;
    }

    /**
     * Adds the Symfony VarDumper
     */
    public static function addVarDumper()
    {
        VarDumper::setHandler(function($var) {
            $cloner = new VarCloner();

            $htmlDumper = new HtmlDumper();
            $htmlDumper->setStyles([
                'default' => 'background-color: #333; color: #ff8400; line-height: 1.2em; font: 12px Menlo, Monaco, Consolas, monospace; word-wrap: break-word; white-space: pre-wrap; position: relative; z-index: 999999; word-break: normal;',
                'public' => 'color: #222',
                'protected' => 'color: #222',
                'private' => 'color: #222',
            ]);

            $htmlDumper->dump($cloner->cloneVar($var));
        });
    }

    /**
     * @param \Slim\App $app
     *
     * @return \Slim\App
     */
    public static function registerWebRoutes(\Slim\App $app): \Slim\App
    {
        require_once __DIR__ . "/../routes/web.php";
        return $app;
    }

    /**
     * @param \Slim\App $app
     *
     * @return \Slim\App
     */
    public static function registerApiRoutes(\Slim\App $app): \Slim\App
    {
        $app->group("/" . $_ENV['API_PREFIX'], function () {
            require_once __DIR__ . "/../routes/api.php";
        });
        return $app;
    }

}