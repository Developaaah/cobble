<?php

namespace App\Controller\Frontend;

use App\Core\Controller;
use App\Helpers\Language\Language;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class IndexController
 *
 * Basic Controller used for testing.
 * To see all default functions of a controller, check out Core\Controller
 *
 * @package App\Controller\Frontend
 */
class IndexController extends Controller
{

    /**
     * @var array|string[]
     */
    protected array $styles = ["main"];

    /**
     * @var array|string[]
     */
    protected array $scripts = ['app'];

    /**
     * Example for downloading a file
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     */
    public function downloadAction(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->fileDownload($response, "TopSecret.zip");
    }

    /**
     * Example for switching the language
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array             $args
     *
     * @return ResponseInterface
     */
    public function lang(RequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        // Cookie Language
        $response = $response->withHeader("Set-Cookie", Language::setCookieLang($args['lang'])->toHeaders());

        // Session Language
        // Language::setSessionLang($args['lang']);

        return $this->redirect($response, "/");
    }

}