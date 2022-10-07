<?php
namespace App\Produit;

use App\Entity\Categorie;
use App\Entity\Ingredient;
use App\Entity\Produit;
use App\Entity\TypeIngredient;
use Doctrine\ORM\EntityManagerInterface;
use Framework\Module;
use Framework\Renderer\RendererInterface;
use Framework\Router\Router;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\RequestInterface;

class ProduitModule extends Module
{
    /**
     * @var RendererInterface
     */
    private RendererInterface $renderer;
    private EntityManagerInterface $manager;

    /**
     * @param ContainerInterface $container
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(ContainerInterface $container)
    {
        $renderer = $container->get(RendererInterface::class);
        $router = $container->get(Router::class);
        $manager = $container->get(EntityManagerInterface::class);
        $renderer->addPath('produit', __DIR__.'/views');
        $this->renderer = $renderer;
        $router->get('/carte', [$this, 'carte'], 'produit.carte');
        $router->get('/panier', [$this, 'panier'], 'produit.panier');
        $router->get('/carte/{id:[0-9]}', [$this, 'show'], 'produit.show');
        $this->manager = $manager;
        if ($container->has('admin.prefix')) {
            $renderer->addPath('produit_admin', __DIR__.'/views/admin');
            $router->get(
                $container->get('admin.prefix') . '/produit/manage',
                [$this, 'manage'],
                'admin.produit.manage'
            );
            $router->post(
                $container->get('admin.prefix') . '/produit/add',
                [$this, 'addProd'],
                'admin.produit.add'
            );
        }
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
        $ingredient = new Ingredient();
        $ingredient->setPrix(0.50);
        $ingredient->setNom('Salade');
        $ingredient->setDispo(1);
        $ingredient->setType();
        $categorie = $this->manager->find(Categorie::class, 1);
        $produit->setCategorie($categorie);
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

    public function manage(RequestInterface $request): string
    {
        $prodRepository = $this->manager->getRepository(Produit::class);
        $produits = $prodRepository->findAll();
        $catRepository = $this->manager->getRepository(Categorie::class);
        $categories = $catRepository->findAll();
        $typeRepository = $this->manager->getRepository(TypeIngredient::class);
        $types = $typeRepository->findAll();
        $ingredientRepository = $this->manager->getRepository(Ingredient::class);
        $ingredients = $ingredientRepository->findAll();
        return $this->renderer->render('@produit_admin/manage', [
            "produits" => $produits,
            "categories" => $categories,
            "types" => $types,
            "ingredients" => $ingredients,
            "active" => "produit"
        ]);
    }

    public function addProd(ServerRequest $request)
    {
        $data = $request->getParsedBody();
        $file = $request->getUploadedFiles()['image']->getStream()->getMetadata();

        var_dump($data, $file);
    }
}
