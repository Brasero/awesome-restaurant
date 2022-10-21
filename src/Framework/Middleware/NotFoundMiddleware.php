<?php

namespace Framework\Middleware;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;

class NotFoundMiddleware extends AbstractMiddleware
{

    public function process(ServerRequestInterface $request)
    {
        return new Response(404, [], "Page introuvable");
    }
}
