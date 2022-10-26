<?php

namespace App\Admin;

use App\Admin\Action\AuthAction;
use Framework\Toaster\Toaster;
use Framework\Module;
use Framework\Renderer\RendererInterface;
use Framework\Renderer\TwigRenderer;
use Framework\Router\RedirectTrait;
use Framework\Router\Router;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Twig\Error\LoaderError;

class AdminModule extends Module
{

    use RedirectTrait;

    public const DEFINITIONS = __DIR__ . DIRECTORY_SEPARATOR . 'config.php';

    /**
     * @var Router
     */
    private Router $router;
    /**
     * @var RendererInterface
     */
    private RendererInterface $renderer;

    /**
     * @var Toaster
     */
    private Toaster $toaster;

    /**
     * @var ContainerInterface
     */
    private ContainerInterface $container;

    /**
     * @param ContainerInterface $container
     * @param AdminTwigExtension $adminTwigExtension
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface|LoaderError
     */
    public function __construct(ContainerInterface $container, AdminTwigExtension $adminTwigExtension)
    {
        $this->router = $container->get(Router::class);
        $this->renderer = $container->get(RendererInterface::class);
        $authAction = $container->get(AuthAction::class);

        if ($this->renderer instanceof TwigRenderer) {
            $this->renderer->getTwig()->addExtension($adminTwigExtension);
        }

        $this->renderer->addPath('admin', __DIR__ . "/views");
        $this->router->get(
            $container->get('admin.prefix').'/authenticate',
            [$authAction, 'authenticate'],
            'admin.auth'
        );
        $this->router->get(
            $container->get('admin.prefix').'/authenticate/first',
            [$authAction, 'authenticateFirst'],
            'admin.auth.first'
        );
        $this->router->post(
            $container->get('admin.prefix').'/authenticate/first',
            [$authAction, 'authenticateFirst']
        );
        $this->router->post($container->get('admin.prefix') . '/authenticate', [$authAction, 'authenticate']);
        $this->router->get($container->get('admin.prefix') . '/logout', [$authAction, 'logout'], 'admin.logout');
    }
}
