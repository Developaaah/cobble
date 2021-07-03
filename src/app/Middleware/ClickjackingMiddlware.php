<?php

namespace App\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ClickjackingMiddlware
 * @package App\Middleware
 */
class ClickjackingMiddlware
{

    /**
     *
     */
    const DENY = "DENY";

    /**
     *
     */
    const SAMEORIGIN = "SAMEORIGIN";

    /**
     *
     */
    const X_FRAME_OPTIONS = 'X-Frame-Options';

    /**
     * @var string
     */
    private string $xFrameOption;

    /**
     * ClickjackingMiddlware constructor.
     *
     * @param string $xFrameOption
     */
    public function __construct(string $xFrameOption = self::SAMEORIGIN)
    {
        $this->xFrameOption = $xFrameOption;
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
        $response = $next($request, $response);

        if ($response->hasHeader(self::X_FRAME_OPTIONS)) {
            return $response;
        }

        return $response->withAddedHeader(self::X_FRAME_OPTIONS, $this->xFrameOption);
    }


}