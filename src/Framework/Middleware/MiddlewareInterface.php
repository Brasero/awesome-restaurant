<?php

namespace App\Framework\Middleware;

use Psr\Http\Message\ServerRequestInterface;

interface MiddlewareInterface
{
    public function linkWith(MiddlewareInterface $middleware): MiddlewareInterface;

    public function process(ServerRequestInterface $request);
}
