<?php

namespace App\Framework\Middleware;

use App\Framework\Session\SessionInterface;
use App\Framework\Toaster\Toaster;
use Framework\Router\RedirectTrait;
use Framework\Router\Router;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ServerRequestInterface;

class AdminAuthMiddleware extends AbstractMiddleware
{

    use RedirectTrait;

    /**
     * @var ContainerInterface
     */
    private ContainerInterface $container;


    /**
     * @var Router
     */
    private Router $router;

    /**
     * @param ContainerInterface $container
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function process(ServerRequestInterface $request)
    {
        $uri = $request->getUri()->getPath();
        if (str_starts_with($uri, $this->container->get('admin.prefix'))
            && $uri !== $this->container->get('admin.prefix') . '/authenticate'
        ) {
            $session = $this->container->get(SessionInterface::class);
            if (!$session->has('auth')) {
                $router = $this->container->get(Router::class);
                $this->router = $router;
                $toaster = $this->container->get(Toaster::class);
                $toaster->createToast('Vous devez être connecté pour accéder à cette page', Toaster::ERROR);
                return $this->redirect('admin.auth');
            }
        }
        return parent::process($request);
    }
}
