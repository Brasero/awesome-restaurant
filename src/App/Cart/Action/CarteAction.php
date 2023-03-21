<?php

namespace App\Cart\Action;

use App\Entity\Categorie;
use App\Entity\Produit;
use App\Entity\TypeIngredient;
use Doctrine\ORM\EntityManagerInterface;
use Framework\Renderer\RendererInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;

class CarteAction
{


    private ContainerInterface $container;
    private EntityManagerInterface $manager;
    private $repository;
    private RendererInterface $renderer;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->manager = $container->get(EntityManagerInterface::class);
        $this->repository = $this->manager->getRepository(Produit::class);
        $this->renderer = $container->get(RendererInterface::class);
    }

    public function index(RequestInterface $request)
    {
        $products = $this->repository->findAll();
        $categorys= $this->manager->getRepository(Categorie::class)->findAll();
        return $this->renderer->render('@carte/carte', compact('products', 'categorys'));
    }

    public function show(RequestInterface $request)
    {
        $id = $request->getAttribute('id', null);
        $product = $this->repository->find($id);
        $ingredientsProd = $product->getIngredients();
        $asCookingType = false;
        foreach ($ingredientsProd as $ingredient) {
            if ($ingredient->getType()->getNom() == "Viande" && str_contains("Boeuf", $ingredient->getNom())) {
                $asCookingType = true;
                break;
            }
        }
        $typeIngredients = $this->manager->getRepository(TypeIngredient::class)->findAll();
        return $this->renderer->render(
            '@carte/show',
            compact('product', 'typeIngredients', 'asCookingType')
        );
    }
}
