<?php

namespace App\Produit\Action;

use App\Entity\Produit;
use Framework\Router\Router;
use Framework\Router\RedirectTrait;
use Framework\Toaster\Toaster;
use GuzzleHttp\Psr7\UploadedFile;
use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManagerInterface;
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

    private $repository;

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
            ->strLenght('produitNom', 3, 50)
            ->intLenght('produitPrix', 0.01, 100)
            ->float('prix')
            ->getErrors();
        if (!empty($errors)) {
            foreach ($errors as $error) {
                $this->toaster->createToats($error, Toaster::ERROR);
            }
        }
        $this->fileGuards($file);
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
            $this->redirect('admin.produit.manage');
        }

        list($type, $format) = explode("/", $file->getClientMediaType());

        //Guard format accépté jpg jpeg png
        if (!in_array($type, ['image']) or !in_array($format, ["jpg", "jpeg", "png"])) {
            $this->toaster->createToast(
                "ERREUR : format non pris en charge, veuillez ajouté un .jpg, .jpeg ou .png",
                Toaster::ERROR
            );
            $this->redirect('admin.produit.manage');
        }

        //Guard taille de l'image inférieur a 2Mo
        if ($file->getSize() > 2047674) {
            $this->toaster->createToast("La taille de votre image dépasse la limite de 2Mo.", Toaster::ERROR);
            return $this->redirect('admin.produit.manage');
        }
        return true;
    }
}
