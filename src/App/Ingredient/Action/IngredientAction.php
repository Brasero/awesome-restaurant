<?php

namespace App\Ingredient\Action;

use App\Entity\Ingredient;
use App\Entity\TypeIngredient;
use Framework\Toaster\Toaster;
use Framework\Validator\Validator;
use Doctrine\ORM\EntityManagerInterface;
use Framework\Router\RedirectTrait;
use Framework\Router\Router;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class IngredientAction
{

    use RedirectTrait;

    /**
     * @var ContainerInterface
     */
    private ContainerInterface $container;

    /**
     * @var Toaster|mixed
     */
    private Toaster $toaster;

    /**
     * @var EntityManagerInterface|mixed
     */
    private EntityManagerInterface $manager;

    /**
     * @var Router
     */
    private Router $router;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->toaster = $container->get(Toaster::class);
        $this->manager = $container->get(EntityManagerInterface::class);
        $this->router = $container->get(Router::class);
    }


    public function add(ServerRequest $request)
    {
        $data = $request->getParsedBody();
        $validator = new Validator($data);
        $errors = $validator->required('nom', 'prix', 'type')
                    ->strLength('nom', 3, 50)
                    ->intLength('prix', 0.01, 5)
                    ->float('prix')
                    ->getErrors();

        if (!empty($errors)) {
            foreach ($errors as $error) {
                $this->toaster->createToast($error, Toaster::ERROR);
            }
            return $this->redirect('admin.ingredient.show');
        }

        /** Verifie que le nom est unique */
        $ing = new Ingredient();
        $repository = $this->manager->getRepository(Ingredient::class);
        $ingredients = $repository->findAll();
        $ing->setNom($data['nom']);
        foreach ($ingredients as $ingredient) {
            if ($ingredient->getNom() === $ing->getNom()) {
                $this->toaster->createToast("ERREUR : Ce nom existe déjà.", Toaster::ERROR);
                return $this->redirect("admin.ingredient.show");
            }
        }

        /** Enregistrement en bdd */
        $ing->setPrix($data['prix']);
        $type = $this->manager->find(TypeIngredient::class, $data['type']);
        $ing->setType($type);
        $ing->setDispo(1);

        $this->manager->persist($ing);
        $this->manager->flush();

        $this->toaster->createToast("Votre ingredient {$ing->getNom()} à bien été ajouté", Toaster::SUCCESS);

        return $this->redirect('admin.ingredient.show');
    }

    /**
     * @param ServerRequest $request
     * @return string
     */
    public function delete(ServerRequest $request): string
    {
        $id = $request->getAttribute('id');
        $ingredient = $this->manager->find(Ingredient::class, $id);
        $this->manager->remove($ingredient);
        $this->manager->flush();
        $ingredient = $this->manager->find(Ingredient::class, $id);
        if (!is_null($ingredient)) {
            return "false";
        }
        return "true";
    }
}
