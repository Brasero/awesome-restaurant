<?php
namespace App\Produit;

use Framework\Module;
use Framework\Renderer\RendererInterface;
use Framework\Router\Router;

class ProduitModule extends Module
{
    /**
     * @var RendererInterface
     */
    private RendererInterface $renderer;

    /**
     * @param Router $router
     * @param RendererInterface $renderer
     */
    public function __construct(Router $router, RendererInterface $renderer)
    {
        $renderer->addPath('produit', __DIR__.'/views');
        $this->renderer = $renderer;
        $router->get('/carte', [$this, 'carte'], 'produit.carte');
        $router->get('/panier', [$this, 'panier'], 'produit.panier');
    }

    public function carte(): string
    {
        return $this->renderer->render('@produit/carte');
    }


    public function panier(): string
    {
        return $this->renderer->render('@produit/panier');
    }
}
