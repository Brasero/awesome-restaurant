<?php

namespace App\Ingredient\Action;

use App\Entity\TypeIngredient;
use App\Framework\Toaster\Toaster;
use App\Framework\Validator\Validator;
use Doctrine\ORM\EntityManagerInterface;
use Framework\Router\RedirectTrait;
use Framework\Router\Router;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class IngredientTypeAction
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
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;


    /**
     * @var Router|mixed
     */
    private Router $router;

    /**
     * @param ContainerInterface $container
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
        $errors = $validator->required('nom')
            ->strLength('nom', 3, 50)
            ->getErrors();

        if (!empty($errors)) {
            foreach ($errors as $error) {
                $this->toaster->createToast($error, Toaster::ERROR);
            }
            return $this->redirect('admin.ingredient.show');
        }

        $type = new TypeIngredient();
        $type->setNom($data['nom']);
        $repository = $this->manager->getRepository(TypeIngredient::class);
        $types = $repository->findAll();
        foreach ($types as $ty) {
            if ($ty->getNom() == $type->getNom()) {
                $this->toaster->createToast("ERREUR : Ce nom existe déjà.", Toaster::ERROR);
                return $this->redirect('admin.ingredient.show');
            }
        }
        $this->manager->persist($type);
        $this->manager->flush();
        $this->toaster->createToast('Votre type '.$type->getNom().' à bien été ajouté', Toaster::SUCCESS);
        return $this->redirect('admin.ingredient.show');
    }


    public function delete(ServerRequest $request): string
    {
        $id = $request->getAttribute('id');
        $type = $this->manager->find(TypeIngredient::class, $id);

        $this->manager->remove($type);
        $this->manager->flush();
        $type = $this->manager->find(TypeIngredient::class, $id);
        if (!is_null($type)) {
            return "false";
        }
        return "true";
    }

    public function update(ServerRequest $request)
    {
        $data = $request->getParsedBody();
        $id = $data['id'];
        $nom = $data['nom'];
        $type = $this->manager->find(TypeIngredient::class, $id);
        $type->setNom($nom);
        $repository = $this->manager->getRepository(TypeIngredient::class);
        $types = $repository->findAll();
        foreach ($types as $ty) {
            if ($ty->getNom() === $type->getNom() && $ty != $type) {
                var_dump($ty->getNom());
                $this->toaster->createToast("ERREUR : Ce nom existe déjà.", Toaster::ERROR);
                return $this->redirect('admin.ingredient.show');
            }
        }
        $this->toaster->createToast('Modification enregistrée', Toaster::SUCCESS);
        $this->manager->persist($type);
        $this->manager->flush();
        return $this->redirect('admin.ingredient.show');
    }
}
