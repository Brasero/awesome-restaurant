<?php

namespace Framework\Middleware;

use Exception;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RouterDispatcherMiddleware extends AbstractMiddleware
{

    /**
     * @throws Exception
     */
    public function process(ServerRequestInterface $request)
    {

        $route = $request->getAttribute('_route');
        if (is_null($route)) {
            return parent::process($request);
        }
        $callback = $route->getCallback();

        $response = call_user_func_array($callback, [$request]);

        if (is_string($response)) {
            return new Response(200, [], $response);
        } elseif ($response instanceof ResponseInterface) {
            return $response;
        } else {
            throw new Exception("Le serveur n'a pas renvoyé de réponse valable.");
        }
    }
}
