<?php

namespace App\Produit;

use App\Entity\Categorie;
use App\Entity\Ingredient;
use App\Entity\Produit;
use App\Entity\Taxe;
use App\Entity\TypeIngredient;
use Framework\TwigExtension\MenuTwigExtension;
use App\Produit\Action\CategorieAction;
use App\Produit\Action\ProduitAction;
use Doctrine\ORM\EntityManagerInterface;
use Framework\Module;
use Framework\Renderer\RendererInterface;
use Framework\Renderer\TwigRenderer;
use Framework\Router\Router;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\RequestInterface;

class ProduitModule extends Module
{

    public const DEFINITIONS = __DIR__ . DIRECTORY_SEPARATOR . 'config.php';

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
        $produitAction = $container->get(ProduitAction::class);
        $categorieAction = new CategorieAction($container);
        $renderer = $container->get(RendererInterface::class);
        $router = $container->get(Router::class);
        $manager = $container->get(EntityManagerInterface::class);
        $renderer->addPath('produit', __DIR__ . '/views');
        $this->renderer = $renderer;
        $router->get('/carte', [$this, 'carte'], 'produit.carte');
        $router->get('/panier', [$this, 'panier'], 'produit.panier');
        $router->get('/supplement', [$this, "supplement"], 'produit.supplement');
        $router->get('/carte/{id:[0-9]}', [$this, 'show'], 'produit.show');
        $this->manager = $manager;
        if ($container->has('admin.prefix')) {
            $prefix = $container->get('admin.prefix');
            $renderer->addPath('produit_admin', __DIR__ . '/views/admin');
            $router->get(
                $prefix . '/produit/manage',
                [$this, 'manage'],
                'admin.produit.manage'
            );
            $router->post(
                $prefix . '/produit/addCategorie',
                [$categorieAction, 'add'],
                'admin.addCategorie'
            );

            $router->post(
                $prefix . '/produit/updateCategorie',
                [$categorieAction, 'update'],
                'admin.Categorie.update'
            );

            $router->get(
                "/ajax/category/delete/{id:\d+}/{apiKey:[a-z0-9-]+}",
                [$categorieAction, 'delete'],
                'ajax.category.delete'
            );
            $router->post(
                $prefix . '/produit/addProduit',
                [$produitAction, 'add'],
                'admin.produit.add'
            );
        }
    }

    public function carte(): string
    {
        $prods = $this->manager->getRepository(Produit::class)->findAll();
        $categories = $this->manager->getRepository(Categorie::class)->findAll();
        return $this->renderer->render('@produit/carte', [
            "products" => $prods,
            "categorys" => $categories
        ]);
    }


    public function panier(): string
    {
        return $this->renderer->render('@produit/panier');
    }

    public function supplement(): string
    {
        return $this->renderer->render('@produit/supplement');
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
        $taxeRepository = $this->manager->getRepository(Taxe::class);
        $taxes = $taxeRepository->findAll();
        $typeRepository = $this->manager->getRepository(TypeIngredient::class);
        $types = $typeRepository->findAll();
        $ingredientRepository = $this->manager->getRepository(Ingredient::class);
        $ingredients = $ingredientRepository->findAll();
        return $this->renderer->render('@produit_admin/manage', [
            "produits" => $produits,
            "categories" => $categories,
            "taxes" => $taxes,
            "types" => $types,
            "ingredients" => $ingredients,
            "active" => "produit"
        ]);
    }
}
