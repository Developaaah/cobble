<?php

namespace App\Core;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class Controller
{

    protected $container;

    protected $title = "Website Title";

    protected $page = "";

    protected $styles = [];

    protected $scripts = [];

    protected $dev = "";

    public function __construct($container)
    {
        $this->container = $container;
        $this->page = getenv('APP_NAME');
        $this->dev = getenv('APP_ENV') === 'development';
    }

    public function index(Request $request, Response $response)
    {
        echo getenv('APP_NAME');
    }

    public function view(string $view, Response $response, array $args )
    {
        $args['title'] = $this->title;
        $args['page'] = $this->page;
        $args['header_incl'] = $this->buildStyles();
        $args['header_incl'] .= $this->buildScripts();

        return $this->container->view->render($response, $view . ".twig", $args);
    }

    public function error(Response $response, string $code, string $message)
    {
        return $this->container->view->render($response, "error.twig", ["code" => $code, "message" => $message]);
    }

    public function json(Response $response, $json)
    {
        return $response->withJson($json, 200);
    }

    public function jsonError(Response $response, int $status = 404, string $message = "Not Found.")
    {
        return $response->withJson([
            "status" => $status,
            "message" => $message], 200);
    }

    protected function buildScripts() : string
    {
        $path = __DIR__ . "/../../public/assets/js/";
        $files = scandir($path);
        $res = "";

        foreach ($this->scripts as $script) {
            foreach ($files as $file) {
                if ($this->dev) {
                    if (preg_match("/(" . $script . "\.js)/", $file)) {
                        $res .= '<script src="/assets/js/' . $file . '"></script>' . PHP_EOL;
                    }
                }
                else {
                    if (preg_match("/(" . $script . "(?:\..+)?\.min.js)/", $file)) {
                        $res .= '<script src="/assets/js/' . $file . '"></script>';
                    }
                }
            }
        }

        return $res;
    }

    protected function buildStyles() : string
    {
        $path = __DIR__ . "/../../public/assets/css/";
        $files = scandir($path);
        $res = "";

        foreach ($this->styles as $style) {
            foreach ($files as $file) {
                if ($this->dev) {
                    if (preg_match("/(" . $style . "\.css)/", $file)) {
                        $res .= '<link rel="stylesheet" href="/assets/css/' . $file . '">' . PHP_EOL;
                    }
                }
                else {
                    if (preg_match("/(" . $style . "(?:\..+)?\.min.css)/", $file)) {
                        $res .= '<link rel="stylesheet" href="/assets/css/' . $file . '">';
                    }
                }
            }
        }

        return $res;
    }
}