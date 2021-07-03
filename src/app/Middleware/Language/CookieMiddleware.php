<?php

namespace App\Middleware\Language;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Cookies;

/**
 * Class CookieMiddleware
 * @package App\Middleware\Language
 */
class CookieMiddleware
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
     * CookieMiddleware constructor.
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
        $cookie = $request->getCookieParam("lang");
        if ($cookie == null || !isset($cookie) || !in_array($cookie, $this->availableLang)) {
            $cookies = new Cookies();
            $cookies->set("lang", [
                "value" => $this->defaultLang,
                "expires" => time() + (86400 * 30),
                "path" => "/",
                "domain" => $_ENV['APP_URL'],
                "secure" => true
            ]);
            $response = $response->withHeader("Set-Cookie", $cookies->toHeaders());
            $cookie = $this->defaultLang;
        }

        return $next($request->withAttribute('lang', $cookie), $response);
    }


}