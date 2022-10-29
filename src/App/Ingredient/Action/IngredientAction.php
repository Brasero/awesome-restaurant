<?php

namespace App\Ingredient\Action;

use App\Entity\Ingredient;
use App\Entity\TypeIngredient;
use Doctrine\ORM\EntityRepository;
use Framework\Toaster\Toaster;
use Framework\Validator\Validator;
use Doctrine\ORM\EntityManagerInterface;
use Framework\Router\RedirectTrait;
use Framework\Router\Router;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ServerRequestInterface;

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
     * @var EntityRepository
     */
    private EntityRepository $repository;

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
        $this->repository = $this->manager->getRepository(Ingredient::class);
    }


    public function add(ServerRequest $request)
    {
        $data = $request->getParsedBody();
        $validator = new Validator($data);
        $errors = $validator->required('nom', 'prix', 'type')
                    ->strLength('nom', 3, 50)
                    ->intLength('prix', 0.01, 100)
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
        $repository = $this->repository;
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

    public function update(ServerRequestInterface $request)
    {
        $id = $request->getParsedBody()['id'];
        $data = $request->getParsedBody();
        $repository = $this->repository;
        $validator = new Validator($data);
        $errors = $validator->required('nom', 'prix', 'type')
                    ->isUnique('nom', $repository, 'nom', $id)
                    ->strLength('nom', 3, 50)
                    ->intLength('prix', 0.01, 100)
                    ->float('prix')
                    ->getErrors();
        if (!empty($errors)) {
            foreach ($errors as $error) {
                $this->toaster->createToast($error, Toaster::ERROR);
            }
            return $this->redirect('admin.ingredient.show');
        }
        $type = $this->manager->getRepository(TypeIngredient::class)->find($data['type']);
        $ingredient = $repository->find($id);
        $ingredient->setNom($data['nom'])
            ->setPrix($data['prix'])
            ->setType($type)
            ->setDispo(1);
        $this->manager->flush();
        $this->toaster->createToast('Modification enregistrée.', Toaster::SUCCESS);
        return $this->redirect('admin.ingredient.show');
    }

    /**
     * @param ServerRequest $request
     * @return string
     */
    public function delete(ServerRequest $request): string
    {
        $id = $request->getAttribute('id');
        $ingredient = $this->repository->find($id);
        $this->manager->remove($ingredient);
        $this->manager->flush();
        $ingredient = $this->repository->find($id);
        if (!is_null($ingredient)) {
            return "false";
        }
        return "true";
    }
}
