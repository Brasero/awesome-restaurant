<?php
namespace App\Produit;

use App\Produit\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Framework\Module;
use Framework\Renderer\RendererInterface;
use Framework\Router\Router;
use GuzzleHttp\Psr7\ServerRequest;

class ProduitModule extends Module
{
    /**
     * @var RendererInterface
     */
    private RendererInterface $renderer;
    private EntityManagerInterface $manager;

    /**
     * @param Router $router
     * @param RendererInterface $renderer
     * @param EntityManagerInterface $manager
     */
    public function __construct(Router $router, RendererInterface $renderer, EntityManagerInterface $manager)
    {
        $renderer->addPath('produit', __DIR__.'/views');
        $this->renderer = $renderer;
        $router->get('/carte', [$this, 'carte'], 'produit.carte');
        $router->get('/panier', [$this, 'panier'], 'produit.panier');
        $router->get('/carte/{id:[0-9]}', [$this, 'show'], 'produit.show');
        $this->manager = $manager;
    }

    public function carte(): string
    {
        $repository = $this->manager->getRepository(Produit::class);
        $prods = $repository->findAll();
        return $this->renderer->render('@produit/carte', [
            "products" => $prods
        ]);
    }


    public function panier(): string
    {
        $produit = new Produit();
        $produit->setId_categorie(1);
        $produit->setId_offre(1);
        $produit->setId_taxe(1);
        $produit->setImg('test/img.jpg');
        $produit->setNom('Produit test');
        $produit->setPrix('1.5');

        $this->manager->persist($produit);
        $this->manager->flush();

        return $this->renderer->render('@produit/panier');
    }


    public function show(ServerRequest $request): string
    {
        $id = $request->getAttribute('id');
        $prod = $this->manager->find(Produit::class, $id);
        return $this->renderer->render('@produit/show', [
            "prod" => $prod
        ]);
    }
}
