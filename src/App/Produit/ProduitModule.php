<?php

namespace App\Produit;

use App\Entity\Taxe;
use Framework\Module;
use App\Entity\Produit;
use App\Entity\Categorie;
use App\Entity\Ingredient;
use Framework\Router\Router;
use App\Entity\TypeIngredient;
use GuzzleHttp\Psr7\ServerRequest;
use Framework\Renderer\TwigRenderer;
use App\Produit\Action\ProduitAction;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use App\Produit\Action\CategorieAction;
use Framework\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;
use Framework\Renderer\RendererInterface;
use Psr\Container\NotFoundExceptionInterface;
use Framework\TwigExtension\MenuTwigExtension;
use Psr\Container\ContainerExceptionInterface;

class ProduitModule extends Module
{

    public const DEFINITIONS = __DIR__ . DIRECTORY_SEPARATOR . 'config.php';

    /**
     * @var RendererInterface
     */
    private RendererInterface $renderer;
    private EntityManagerInterface $manager;
    private SessionInterface $session;

    /**
     * @param ContainerInterface $container
     * @param SessionInterface $session
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(ContainerInterface $container, SessionInterface $session)
    {
        $this->session = $session;
        $produitAction = $container->get(ProduitAction::class);
        $categorieAction = new CategorieAction($container);
        $renderer = $container->get(RendererInterface::class);
        $router = $container->get(Router::class);
        $manager = $container->get(EntityManagerInterface::class);
        $renderer->addPath('produit', __DIR__ . '/views');
        $this->renderer = $renderer;
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
            $router->get(
                $prefix . '/produit/manage/updateProduit/{id:\d+}',
                [$produitAction, 'update'],
                'admin.produit.update'
            );
            $router->post(
                $prefix . '/produit/manage/updateProduit/{id:\d+}',
                [$produitAction, 'update']
            );
            $router->get(
                "/ajax/produit/delete/{id:\d+}",
                [$produitAction, 'delete'],
                'ajax.produit.delete'
            );
        }
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
