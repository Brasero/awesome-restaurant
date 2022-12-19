<?php

namespace Framework\Middleware;

use Framework\Auth\AdminAuth;
use Framework\Session\SessionInterface;
use Framework\Toaster\Toaster;
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
            && (
                $uri !== $this->container->get('admin.prefix') . '/authenticate'
                && $uri !== $this->container->get('admin.prefix') . '/authenticate/first'
                )
        ) {
            $auth = $this->container->get(AdminAuth::class);
            if (!$auth->isLogged() || !$auth->checkTimestamp()) {
                $router = $this->container->get(Router::class);
                $this->router = $router;
                $toaster = $this->container->get(Toaster::class);
                if (!$auth->isLogged()) {
                    $toaster->createToast('Vous devez être connecté pour accéder à cette page', Toaster::ERROR);
                } elseif (!$auth->isAdmin()) {
                    $toaster->createToast('Vous n\'avez pas les droits pour accéder à cette page', Toaster::ERROR);
                } else {
                    $toaster->createToast('Votre session a expiré', Toaster::ERROR);
                }
                return $this->redirect('admin.auth');
            }
        }
        return parent::process($request);
    }
}
