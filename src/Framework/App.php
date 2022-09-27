<?php
namespace Framework;

use Framework\Router\Router;
use GuzzleHttp\Psr7\Response;
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
     *
     * @var Router
     */
    public $router;

    public function __construct(array $modules = [])
    {
        $this->router = new Router();
        foreach($modules as $module){
           $this->modules[] = new $module($this->router); 
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

        return new Response(200, [], 'bonjour');
    }
}