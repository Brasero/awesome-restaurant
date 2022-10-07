<?php

namespace App\Admin;

use Framework\Module;
use Framework\Renderer\RendererInterface;
use Framework\Router\Router;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\RequestInterface;

class AdminModule extends Module
{

    public const DEFINITIONS = __DIR__ . '/config.php';

    /**
     * @var Router
     */
    private Router $router;
    /**
     * @var RendererInterface
     */
    private RendererInterface $renderer;

    /**
     * @param ContainerInterface $container
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(ContainerInterface $container)
    {
        $router = $container->get(Router::class);
        $renderer = $container->get(RendererInterface::class);

        $renderer->addPath('admin', __DIR__."/views");
        $this->router = $router;
        $this->renderer = $renderer;
        $this->router->get($container->get('admin.prefix').'/authenticate', [$this, 'authenticate'], 'admin.auth');
    }

    public function authenticate(RequestInterface $request): string
    {

        return $this->renderer->render('@admin/connexion');
    }
}
