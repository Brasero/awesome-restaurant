<?php

namespace Framework\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractMiddleware implements MiddlewareInterface
{

    /**
     * @var MiddlewareInterface
     */
    protected MiddlewareInterface $next;

    /**
     * @param MiddlewareInterface $middleware
     * @return MiddlewareInterface
     */
    public function linkWith(MiddlewareInterface $middleware): MiddlewareInterface
    {
        $this->next = $middleware;
        return $middleware;
    }

    public function process(ServerRequestInterface $request)
    {
        return $this->next->process($request);
    }
}
