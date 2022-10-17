<?php

namespace App\Ingredient;

use App\Entity\Ingredient;
use App\Entity\TypeIngredient;
use App\Ingredient\Action\IngredientAction;
use App\Ingredient\Action\IngredientTypeAction;
use Doctrine\ORM\EntityManagerInterface;
use Framework\Module;
use Framework\Renderer\RendererInterface;
use Framework\Router\RedirectTrait;
use Framework\Router\Router;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class IngredientModule extends Module
{
    use RedirectTrait;

    /**
     * @var ContainerInterface
     */
    private ContainerInterface $container;

    /**
     * @var RendererInterface
     */
    private RendererInterface $renderer;

    /**
     * @var Router
     */
    private Router $router;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;


    /**
     * @param ContainerInterface $container
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(ContainerInterface $container)
    {
        $typeAction = new IngredientTypeAction($container);
        $ingredientAction = new IngredientAction($container);
        $this->container = $container;
        $this->renderer = $container->get(RendererInterface::class);
        $this->router = $container->get(Router::class);
        $this->manager = $container->get(EntityManagerInterface::class);
        $this->renderer->addPath('ingredient', __DIR__.'/views');
        $this->router->get('/admin/ingredient', [$this, 'show'], 'admin.ingredient.show');
        $this->router->get(
            '/ajax/ingredient/delete/{id:[0-9]+}',
            [$ingredientAction, 'delete'],
            'ajax.ingredient.delete'
        );
        $this->router->post(
            '/admin/ingredient/addIngredient',
            [$ingredientAction, 'add'],
            'admin.ingredient.add'
        );
        $this->router->get(
            '/ajax/type/delete/{id:[0-9]+}',
            [$typeAction, 'delete'],
            'ajax.type.delete'
        );
        $this->router->post(
            '/admin/ingredient/addtype',
            [$typeAction, 'add'],
            'admin.ingredient.addtype'
        );
        $this->router->post(
            '/admin/ingredient/updatetype',
            [$typeAction, 'update'],
            'admin.ingredient.updateType'
        );
    }


    public function show(ServerRequest $request): string
    {
        $toast = $request->getAttribute('toast');
        $repository = $this->manager->getRepository(Ingredient::class);
        $ingredients = $repository->findAll();
        $repository = $this->manager->getRepository(TypeIngredient::class);
        $types = $repository->findAll();
        return $this->renderer->render('@ingredient/show', [
            "ingredients" => $ingredients,
            "types" => $types,
            "toast" => $toast,
            "active" => "ingredient"
        ]);
    }
}