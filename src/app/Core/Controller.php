<?php

namespace App\Core;

use App\Helpers\CSRF\CSRF;
use App\Helpers\Language\Language;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Stream;

/**
 * Class Controller
 * @package App\Core
 */
class Controller
{

    /**
     * Contains the controller, so you'll always have access to it.
     *
     * @var ContainerInterface
     */
    protected ContainerInterface $container;

    /**
     * Defines, if the ENV is development
     *
     * @var bool
     */
    protected bool $isDev = false;

    /**
     * The base path where the current views are.
     * No trailing or leading directory separators allowed.
     *
     * @var string
     */
    protected string $viewBasePath = "frontend";

    /**
     * Sets the directory separator used for the path for the view
     *
     * @var string
     */
    protected string $ds = DIRECTORY_SEPARATOR;


    /**
     * Includes all defined scripts into the incl.scripts twig variable.
     * Path starts at /dist/public/assets/js
     *
     * @var array
     */
    protected array $scripts = [];

    /**
     * Includes all defined styles into the incl.styles twig variable.
     * Path starts at /dist/public/assets/css
     *
     * @var array
     */
    protected array $styles = [];

    /**
     * Controller constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->isDev = $_ENV['APP_ENV'] === 'development';
    }

    /**
     * Sets the default function to index().
     * Used, if no specific callable function is defined in the route
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array             $args
     *
     * @return ResponseInterface
     */
    public function __invoke(RequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
    {
        return $this->index($request, $response, $args);
    }

    /**
     * The default function for a html response with a twig template.
     * Main entry point for the route.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array             $args
     *
     * @return ResponseInterface
     */
    public function index(RequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
    {
        $lang = $request->getAttributes()['lang'];
        return $this->view("index", $response, [
            "lang" => Language::getLang($lang)
        ]);
    }

    /**
     * Returns the current view with all arguments provided.
     * Can also contain defaults, which are always part of a html response.
     *
     * @param string            $view
     * @param ResponseInterface $response
     * @param array             $args
     *
     * @return ResponseInterface
     */
    public function view(string $view, ResponseInterface $response, array $args = []): ResponseInterface
    {
        $path = $this->ds . $this->viewBasePath . $this->ds . $view . ".twig";
        $args['csrf'] = $_SESSION['csrf'] = CSRF::createToken($path);
        $args['incl'] = [
            'scripts' => $this->build("js", $this->scripts),
            'styles' => $this->build("css", $this->styles)
        ];
        $args['session'] = $_SESSION;
        return $this->container->get('view')->render($response, $path, $args);
    }

    /**
     * Redirects you to another page based on the path.
     * Has to be absolute.
     *
     * @param ResponseInterface $response
     * @param string            $path
     *
     * @return ResponseInterface
     */
    public function redirect(ResponseInterface $response, string $path): ResponseInterface
    {
        return $response->withRedirect($path, 301);
    }

    /**
     * Returns a response with content-type application/json.
     *
     * @param ResponseInterface $response
     * @param array             $json
     *
     * @return ResponseInterface
     */
    public function withJson(ResponseInterface $response, array $json = []): ResponseInterface
    {
        return $response->withJson($json, 200);
    }

    /**
     * Returns a JSON Response with status, message and a dataset.
     * Used for API and AJAX calls, where you have a e.g. success or error message.
     *
     * @param ResponseInterface $response
     * @param int               $status
     * @param array             $data
     * @param string|mixed      $message
     *
     * @return ResponseInterface
     */
    public function withJsonStatus(ResponseInterface $response, int $status, string $message = "", array $data = []): ResponseInterface
    {
        return $response->withJson([
            "message" => $message,
            "data" => $data
        ], $status);
    }

    /**
     * Return the 404 Page defined in the error views
     *
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     */
    public function notFound(ResponseInterface $response): ResponseInterface
    {
        return $this->container->get("view")->render($response, "/error/404.twig", []);
    }

    /**
     * @param ResponseInterface $response
     * @param string            $file can be a path or direct filename (no beginning slash)
     *
     * @return ResponseInterface
     */
    public function fileDownload(ResponseInterface $response, string $file): ResponseInterface
    {
        $file = __DIR__ . "/../../upload/" . $file;
        $fh = fopen($file, "rb");

        $stream = new Stream($fh);

        return $response->withHeader('Content-Type', 'application/force-download')
                        ->withHeader('Content-Type', 'application/octet-stream')
                        ->withHeader('Content-Type', 'application/download')
                        ->withHeader('Content-Description', 'File Transfer')
                        ->withHeader('Content-Transfer-Encoding', 'binary')
                        ->withHeader('Content-Disposition', 'attachment; filename="' . basename($file) . '"')
                        ->withHeader('Expires', '0')
                        ->withHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
                        ->withHeader('Pragma', 'public')
                        ->withBody($stream);
    }

    /**
     * Builds the imports for the scripts and styles
     *
     * @param string $type
     * @param array  $data
     *
     * @return string
     */
    public function build(string $type, array $data): string
    {
        $path = __DIR__ . "/../../public/assets/" . $type . "/";
        $files = scandir($path);
        $includes = "";

        foreach ($data as $incl) {
            foreach ($files as $file) {
                $found = false;
                if ($this->isDev) {
                    if (preg_match("/(" . $incl . "\." . $type . ")/", $file)) {
                        $found = true;
                    }
                }
                else {
                    if (preg_match("/(" . $incl . "(?:\..+)?\.min\." . $type . ")/", $file)) {
                        $found = true;
                    }
                }

                if ($found) {
                    if ($type == "css") {
                        $includes .= '<link rel="stylesheet" href="/assets/' . $type . '/' . $file . '">';
                    }
                    elseif ($type == "js") {
                        $includes .= '<script src="/assets/' . $type . '/' . $file . '"></script>';
                    }
                }
            }
        }
        return $includes;
    }

}