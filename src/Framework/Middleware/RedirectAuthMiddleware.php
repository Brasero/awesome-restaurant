<?php

namespace App\Framework\Middleware;

use App\Framework\Session\SessionInterface;
use Framework\Router\RedirectTrait;
use Framework\Router\Router;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

class RedirectAuthMiddleware extends AbstractMiddleware
{

    use RedirectTrait;

    /**
     * @var ContainerInterface
     */
    private ContainerInterface $container;

    private Router $router;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function process(ServerRequestInterface $request)
    {
        $uri = $request->getUri()->getPath();
        if ($uri === $this->container->get('admin.prefix')) {
            $session = $this->container->get(SessionInterface::class);
            $this->router = $this->container->get(Router::class);
            if ($session->has('auth')) {
                return $this->redirect('admin.home');
            }
            return parent::process($request);
        }
        return parent::process($request);
    }
}
