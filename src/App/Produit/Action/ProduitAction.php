<?php

namespace App\Produit\Action;

use App\Entity\Categorie;
use App\Entity\Ingredient;
use App\Entity\Produit;
use App\Entity\Taxe;
use Framework\Router\Router;
use Framework\Router\RedirectTrait;
use Framework\Toaster\Toaster;
use GuzzleHttp\Psr7\UploadedFile;
use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Framework\Validator\Validator;
use GuzzleHttp\Psr7\ServerRequest;

class ProduitAction
{
    use RedirectTrait;

    /**
     * @var ContainerInterface
     */
    private ContainerInterface $container;

    /**
     * @var Toaster
     */
    private Toaster $toaster;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;

    /**
     * @var Router
     */
    private Router $router;

    private EntityRepository $repository;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->toaster = $container->get(Toaster::class);
        $this->manager = $container->get(EntityManagerInterface::class);
        $this->router = $container->get(Router::class);
        $this->repository = $this->manager->getRepository(Produit::class);
    }

    public function add(ServerRequest $request)
    {
        $data = $request->getParsedBody();
        $file = $request->getUploadedFiles()['image'];
        $validator = new Validator($data);
        $errors = $validator->required('produitNom', 'produitPrix', 'categorie')
            ->strLength('produitNom', 3, 50)
            ->intLength('produitPrix', 0.01, 100)
            ->float('produitPrix')
            ->isUnique('produitNom', $this->repository)
            ->getErrors();
        if (!empty($errors)) {
            foreach ($errors as $error) {
                $this->toaster->createToast($error, Toaster::ERROR);
            }
            return $this->redirect('admin.produit.manage');
        }

        $this->fileGuards($file);
        $fileName = $file->getClientFileName();
        $file->moveTo($this->container->get('produit.img.basePath') . $fileName);
        if (!$file->isMoved()) {
            $this->toaster->createToast("ERREUR : problème", Toaster::class);
            return $this->redirect('admin.produit.manage');
        }

        $prod = new Produit();
        $prod->setNom($data['produitNom']);
        $prod->setImg($fileName);
        if (
            isset($data['ingredients']) &&
            sizeof($data['ingredients']) > 0
        ) {
            foreach ($data['ingredients'] as $id) {
                $ingredient = $this->manager->getRepository(Ingredient::class)->find($id);
                $prod->setIngredients($ingredient);
            }
        }


        /** Enregistrement en bdd */
        $prod->setPrix($data['produitPrix']);
        $categorie = $this->manager->find(Categorie::class, $data['categorie']);
        $prod->setCategorie($categorie);
        $taxe = $this->manager->find(Taxe::class, $data['taxe']);
        $prod->setTaxe($taxe);

        $this->manager->persist($prod);
        $this->manager->flush();

        $this->toaster->createToast("Votre produit {$prod->getNom()} à bien été ajouté", Toaster::SUCCESS);

        return $this->redirect('admin.produit.manage');
    }

    /**
     * Effectue certaine vérification sur l'image soumise
     * @param UploadedFile $file
     * @return bool|MessageInterface
     */
    private function fileGuards(UploadedFile $file)
    {
        //Guard erreur de chargement server
        if ($file->getError() === 4) {
            $this->toaster->createToast("Une erreur est survenu lors du chargement de votre image", Toaster::ERROR);
            return $this->redirect('admin.produit.manage');
        }

        list($type, $format) = explode("/", $file->getClientMediaType());

        //Guard format accépté jpg jpeg png
        if (!in_array($type, ['image']) or !in_array($format, ["jpg", "jpeg", "png"])) {
            $this->toaster->createToast(
                "ERREUR : format non pris en charge, veuillez ajouté un .jpg, .jpeg ou .png",
                Toaster::ERROR
            );
            return $this->redirect('admin.produit.manage');
        }

        //Guard taille de l'image inférieur a 2Mo
        if ($file->getSize() > 2047674) {
            $this->toaster->createToast("La taille de votre image dépasse la limite de 2Mo.", Toaster::ERROR);
            return $this->redirect('admin.produit.manage');
        }
        return true;
    }
}
