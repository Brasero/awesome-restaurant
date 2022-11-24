<?php

namespace App\Cart;

use App\Cart\Action\CarteAction;
use App\Cart\Action\PanierAction;
use Doctrine\ORM\EntityManagerInterface;
use Framework\Renderer\RendererInterface;
use Framework\Router\Router;
use Framework\Toaster\Toaster;
use Psr\Container\ContainerInterface;

class CartModule extends \Framework\Module
{

    public const DEFINITIONS = __DIR__ . DIRECTORY_SEPARATOR . 'config.php';

    private ContainerInterface $container;
    private Toaster $toaster;
    private Router $router;

    public function __construct(ContainerInterface $container)
    {
        $panierAction = new PanierAction($container);
        $carteAction = new CarteAction($container);
        $this->container = $container;
        $this->toaster = $container->get(\Framework\Toaster\Toaster::class);
        $this->router = $container->get(\Framework\Router\Router::class);
        $renderer = $container->get(RendererInterface::class);

        $renderer->addPath('carte', __DIR__ . '/views');
        $renderer->addPath('panier', __DIR__ . '/views');

        $this->router->get('/panier', [$panierAction, 'index'], 'panier.index');
        $this->router->get('/carte', [$carteAction, 'index'], 'carte.index');
        $this->router->get('/carte/show/{id:\d+}', [$carteAction, 'show'], 'carte.show');
        $this->router->get('/panier/add/{id:\d+}', [$panierAction, 'add'], 'panier.add');
        $this->router->get('/panier/less/{id:\d+}', [$panierAction, 'decrease'], 'panier.decrease');
        $this->router->get('/panier/more/{id:\d+}', [$panierAction, 'increase'], 'panier.increase');
        $this->router->get('/panier/remove/{id:\d+}', [$panierAction, 'remove'], 'panier.remove');
        $this->router->post("/panier/add/{id:\d+}", [$panierAction, 'add']);
    }
}
