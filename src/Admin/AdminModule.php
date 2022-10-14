<?php

namespace App\Admin;

use App\Framework\Session\SessionInterface;
use App\Framework\Toaster\Toaster;
use Framework\Module;
use Framework\Renderer\RendererInterface;
use Framework\Renderer\TwigRenderer;
use Framework\Router\RedirectTrait;
use Framework\Router\Router;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;

class AdminModule extends Module
{

    use RedirectTrait;

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
     * @throws NotFoundExceptionInterface
     */
    public function __construct(ContainerInterface $container, AdminTwigExtension $adminTwigExtension)
    {
        $router = $container->get(Router::class);
        $renderer = $container->get(RendererInterface::class);
        $this->toaster = $container->get(Toaster::class);

        if ($renderer instanceof TwigRenderer) {
            $renderer->getTwig()->addExtension($adminTwigExtension);
        }

        $renderer->addPath('admin', __DIR__."/views");
        $this->router = $router;
        $this->renderer = $renderer;
        $this->router->get($container->get('admin.prefix').'/authenticate', [$this, 'authenticate'], 'admin.auth');
        $this->router->post($container->get('admin.prefix') . '/authenticate', [$this, 'authenticate']);
        $this->router->get($container->get('admin.prefix') . '/logout', [$this, 'logout'], 'admin.logout');
        $this->container = $container;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function authenticate(ServerRequest $request)
    {
        $method = $request->getMethod();
        if ($method === 'POST') {
            $session = $this->container->get(SessionInterface::class);
            $params = $request->getParsedBody();
            $username = $params['username'] ?? null;
            $password = $params['password'] ?? null;
            if ($username === 'admin' && $password === 'admin' or $session->get('auth')) {
                $session->set('auth', true);
                $this->toaster->createToast('Vous êtes connecté', Toaster::SUCCESS);
                return $this->redirect('admin.home');
            }
            $this->toaster->createToast('Identifiant ou mot de passe inconnu.', Toaster::ERROR);
            return $this->redirect('admin.auth');
        }

        return $this->renderer->render('@admin/connexion');
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function logout(): MessageInterface
    {
        $session = $this->container->get(SessionInterface::class);
        $session->delete('auth');
        $this->toaster->createToast('Vous êtes déconnecté', Toaster::SUCCESS);
        return $this->redirect('admin.auth');
    }
}
