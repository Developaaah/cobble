<?php

namespace App\Middleware\Language;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class SessionMiddleware
 * @package App\Middleware\Language
 */
class SessionMiddleware
{

    /**
     * @var string
     */
    private string $defaultLang;

    /**
     * @var array|string[]
     */
    private array $availableLang;

    /**
     * SessionMiddleware constructor.
     *
     * @param string         $default
     * @param array|string[] $available
     */
    public function __construct(string $default = 'en_US', array $available = ['en_US'])
    {
        $this->defaultLang = $default;
        $this->availableLang = $available;
    }

    /**
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param                   $next
     *
     * @return ResponseInterface
     */
    public function __invoke(RequestInterface $request, ResponseInterface $response, $next): ResponseInterface
    {

        if (isset($_SESSION['lang'])) {
            if (!in_array($_SESSION['lang'], $this->availableLang)) {
                $_SESSION['lang'] = $this->defaultLang;
            }
        }
        else {
            $_SESSION['lang'] = $this->defaultLang;
        }

        $_SESSION['lang_available'] = $this->availableLang;

        return $next($request->withAttribute('lang', $_SESSION['lang']), $response);

    }


}