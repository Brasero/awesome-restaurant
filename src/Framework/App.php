<?php
namespace Framework;

use Framework\Router\Router;
use GuzzleHttp\Psr7\Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class App
{
    /**
     * Liste des modules de l'application
     *
     * @var array
     */
    private $modules;

    /**
     * Conteneur de dépendances
     *
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container, array $modules = [])
    {
        $this->container = $container;
        foreach($modules as $module){
           $this->modules[] = $container->get($module); 
        }
    }

    public function run(ServerRequestInterface $request): ResponseInterface
    {
        $uri = $request->getUri()->getPath();
        if (!empty($uri) && $uri[-1] === "/") {
            return (new Response())
                    ->withStatus(301)
                    ->withHeader('Location', substr($uri, 0, -1));
        }

        $router = $this->container->get(Router::class);
        $route = $router->match($request);

        if(is_null($route))
        {
            return new Response(404, [], "<h1>Erreur 404</h1>");
        }

        $params = $route->getParams();
        $request = array_reduce(array_keys($params), function ($request, $key) use ($params) {
            return $request->withAttribute($key, $params[$key]);
        }, $request);

        $callback = $route->getCallback();

        $response = call_user_func_array($callback, [$request]);

        if(is_string($response))
        {
            return new Response(200, [], $response);
        }
        elseif($response instanceof ResponseInterface)
        {
            return $response;
        }
        else
        {
            throw new \Exception("The response is not available");
        }
    }
}