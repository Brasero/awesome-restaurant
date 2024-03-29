<?php

namespace App\Produit\Action;

use App\Entity\Categorie;
use Framework\Toaster\Toaster;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Framework\Router\RedirectTrait;
use Framework\Router\Router;
use Framework\Validator\Validator;
use GuzzleHttp\Psr7\ServerRequest;
use GuzzleHttp\Psr7\UploadedFile;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\MessageInterface;

class CategorieAction
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
     * @var Router|mixed
     */
    private Router $router;
    private $repository;

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
        $this->repository = $this->manager->getRepository(Categorie::class);
    }

    /**
     * @param ServerRequest $request
     * @return MessageInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function add(ServerRequest $request): MessageInterface
    {
        $data = $request->getParsedBody();
        $file = $request->getUploadedFiles()['image'];

        $this->fileGuards($file);

        $fileName = $file->getClientFileName();
        $repository = $this->repository;
        $categorys = $repository->findAll();
        $newCategorie = new Categorie();
        $newCategorie->setNom($data['nom']);
        $newCategorie->setImg($fileName);
        foreach ($categorys as $category) {
            if ($category->getNom() === $newCategorie->getNom()) {
                $this->toaster->createToast("ERREUR : Cette catégorie existe déjà.", Toaster::ERROR);
                return $this->redirect('admin.produit.manage');
            }
        }

        $file->moveTo($this->container->get('categorie.img.basePath') . $fileName);
        //Guard déplacement de l'image
        if (!$file->isMoved()) {
            $this->toaster->createToast("ERREUR : problème", Toaster::ERROR);
            $this->redirect('admin.produit.manage');
        }


        $this->manager->persist($newCategorie);
        $this->manager->flush();
        $this->toaster->createToast("Votre catégorie {$newCategorie->getNom()} à bien été ajoutée.", Toaster::SUCCESS);
        return $this->redirect('admin.produit.manage');
    }

    /**
     * @param ServerRequest $request
     * @return string
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function delete(ServerRequest $request): string
    {
        $id = $request->getAttribute('id');
        $apiKey = $request->getAttribute('apiKey');
        if ($apiKey != "aed2548sqsa214dcq-gdfsd56q") {
            return "false";
        }
        $categorie = $this->repository->find($id);
        $imagePath = $this->container->get('categorie.img.basePath');
        $imagePath .= $categorie->getImg();
        $this->deleteImage($imagePath);
        $this->manager->remove($categorie);
        $this->manager->flush();
        return "true";
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

    public function update(ServerRequest $request)
    {
        $data = $request->getParsedBody();
        $file = $request->getUploadedFiles()['imageupdate'];
        $id = $data['id'];
        $nom = $data['nom'];
        $data['img'] = $file->getClientFileName();
        $categorieProduit = $this->repository->find($id);
        $validator= new Validator($data);
        $validator->required('nom')
            ->strLength('nom', 3, 50)
            ->isUnique('nom', $this->repository, 'nom', '', $id);
        $categorieProduit->setNom($nom);

        if ($file->getError() != 4) {
            $validator->isUnique('img', $this->repository, 'img', '', $id);
            $this->fileGuards($file);
            $ancienneImage= $this->container->get('categorie.img.basePath');
            $ancienneImage .= $categorieProduit->getImg();
            $categorieProduit->setImg($file->getClientFileName());
        }
        // Si les données sont invalides
        $errors = $validator->getErrors();
        if (!empty($errors)) {
            foreach ($errors as $error) {
                $this->toaster->createToast($error, Toaster::ERROR);
            }
            return $this->redirect('admin.Taxe.show');
        }

        if ($file->getError() != 4) {
            $file->moveTo($this->container->get('categorie.img.basePath') . $file->getClientFileName());

            if (!$file->isMoved()) {
                $this->toaster->createToast("ERREUR : problème", Toaster::ERROR);
                $this->redirect('admin.produit.manage');
            }
            $this->deleteImage($ancienneImage);
        }

        $this->toaster->createToast('Modification enregistrée', Toaster::SUCCESS);
        $this->manager->persist($categorieProduit);
        $this->manager->flush();
        return $this->redirect('admin.produit.manage');
    }

    /**
     * @param string $path
     * @return void
     */
    private function deleteImage(string $path): void
    {
        unlink($path);
    }
}
