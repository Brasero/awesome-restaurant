<?php

namespace Framework\Middleware;

use Framework\Router\Router;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ServerRequestInterface;

class RouterMiddleware extends AbstractMiddleware
{

    /**
     * @var ContainerInterface
     */
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function process(ServerRequestInterface $request)
    {
        $router = $this->container->get(Router::class);
        $route = $router->match($request);
        if (is_null($route)) {
            return $this->next->process($request);
        }

        $params = $route->getParams();
        $request = array_reduce(array_keys($params), function ($request, $key) use ($params) {
            return $request->withAttribute($key, $params[$key]);
        }, $request);

        $request = $request->withAttribute('_route', $route);

        return parent::process($request);
    }
}
