<?php
namespace Framework\Router;

use Framework\Router\Route;
use Zend\Expressive\Router\FastRouteRouter;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Router\Route as ZendRoute;

class Router
{

    /**
     *
     * @var FastRouteRouter
     */
    private $router;

    /**
     * Liste des routes disponibles
     *
     * @var array
     */
    private $routes = [];

    public function __construct()
    {
        $this->router = new FastRouteRouter();
    }

    public function get(string $path, $callable, string $name)
    {
        $this->router->addRoute(new ZendRoute($path, $callable, ['GET'], $name));
        $this->routes[] = $name;
    }

    public function post(string $path, $callable, ?string $name = null)
    {
        $this->router->addRoute(new ZendRoute($path, $callable, ['POST'], $name));
        $this->routes[] = $name;
    }

    public function match(ServerRequestInterface $request): ?Route
    {
        $result = $this->router->match($request);

        if ($result->isSuccess()) {
            return new Route(
                $result->getMatchedRouteName(),
                $result->getMatchedMiddleware(),
                $result->getMatchedParams()
            );
        }

        return null;
    }

    public function generateUrl(string $name, array $params = []): ?string
    {
        return $this->router->generateUri($name, $params);
    }
}
