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
    }
}
