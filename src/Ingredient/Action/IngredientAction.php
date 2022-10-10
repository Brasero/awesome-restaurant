<?php

namespace App\Ingredient\Action;

use App\Entity\Ingredient;
use App\Entity\TypeIngredient;
use App\Framework\Toaster\Toaster;
use Doctrine\ORM\EntityManagerInterface;
use Framework\Router\RedirectTrait;
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
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->toaster = $container->get(Toaster::class);
        $this->manager = $container->get(EntityManagerInterface::class);
    }


    public function add(ServerRequest $request)
    {
        $data = $request->getParsedBody();

        if (!isset(
            $data['nom'],
            $data['prix'],
            $data['type']
        )
            or empty($data['nom'])
            or empty($data['prix'])
            or empty($data['type'])
            or $data['type'] == "false"
        ) {
            $this->toaster->createToast('Merci de renseigner tout les champs', Toaster::ERROR);
            return $this->redirect('admin.ingredient.show');
        }

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
