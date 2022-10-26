<?php
namespace Framework;

use Framework\Middleware\MiddlewareInterface;
use DI\ContainerBuilder;
use Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class App
{
    /**
     * Liste des modules de l'application
     *
     * @var array
     */
    private array $modules;

    /**
     * @var MiddlewareInterface
     */
    private MiddlewareInterface $middleware;

    /**
     * Conteneur de dépendances
     *
     * @var ContainerInterface
     */
    private ContainerInterface $container;


    /**
     * Chemin du fichier de configuration
     * @var string
     */
    private string $definitions;

    /**
     */
    public function __construct(string $definitions)
    {
        $this->definitions = $definitions;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    public function run(ServerRequestInterface $request): ResponseInterface
    {
        foreach ($this->modules as $module) {
            $this->getContainer()->get($module);
        }
        return $this->middleware->process($request);
    }

    /**
     * @return ContainerInterface
     * @throws Exception
     */
    public function getContainer(): ContainerInterface
    {
        if (empty($this->container)) {
            $builder = new ContainerBuilder();
            $builder->addDefinitions($this->definitions);

            foreach ($this->modules as $module) {
                if ($module::DEFINITIONS) {
                    $builder->addDefinitions($module::DEFINITIONS);
                }
            }
            $this->container = $builder->build();
        }

        return $this->container;
    }

    public function linkMiddleware(MiddlewareInterface $middleware): MiddlewareInterface
    {
        $this->middleware = $middleware;
        return $middleware;
    }

    public function addModule($module): self
    {
        $this->modules[] = $module;
        return $this;
    }
}
