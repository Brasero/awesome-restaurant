<?php

namespace App\Produit\Action;

use App\Entity\Categorie;
use App\Entity\Ingredient;
use App\Entity\Produit;
use App\Entity\Taxe;
use App\Entity\TypeIngredient;
use Framework\Router\Router;
use Framework\Router\RedirectTrait;
use Framework\Toaster\Toaster;
use GuzzleHttp\Psr7\UploadedFile;
use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Framework\Renderer\RendererInterface;
use Framework\Validator\Validator;
use GuzzleHttp\Psr7\ServerRequest;
use SebastianBergmann\CodeCoverage\Report\Html\Renderer;

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

    private RendererInterface $renderer;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->toaster = $container->get(Toaster::class);
        $this->manager = $container->get(EntityManagerInterface::class);
        $this->router = $container->get(Router::class);
        $this->repository = $this->manager->getRepository(Produit::class);
        $this->renderer = $container->get(RendererInterface::class);
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
        //
        $prod->setDescription($data["produitDescription"]);
        //
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

    public function update(ServerRequest $request)
    {
        $method = $request->getMethod();

        $id = $request->getAttribute('id');
        $produit = $this->repository->find($id);


        if ($method === 'POST') {
            $data = $request->getParsedBody();
            var_dump($data['produitNomUpdate'], $data['produitPrixUpdate']);
            $file = $request->getUploadedFiles()['imageupdate'] ?? null;
            $validator = new Validator($data);
            $errors = $validator->required('produitNomUpdate', 'produitPrixUpdate', 'categorie')
                ->strLength('produitNomUpdate', 3, 50)
                ->intLength('produitPrixUpdate', 0.01, 100)
                ->float('produitPrixUpdate')
                ->isUnique('produitNomUpdate', $this->repository, 'nom', 'Ce produit existe déjà', $id)
                ->getErrors();

            if (!empty($errors)) {
                foreach ($errors as $error) {
                    $this->toaster->createToast($error, Toaster::ERROR);
                }
                return $this->redirect('admin.produit.update', ['id' => $id]);
            }
            $categorie = $this->manager->getRepository(Categorie::class)->find($data['categorie']);
            $produit->setNom($data['produitNomUpdate'])
                ->setPrix($data['produitPrixUpdate'])
                ->setCategorie($categorie);
            if (!is_null($file)) {
                if ($file->getError() != 4) {

                    $data['img'] = $file->getClientFileName();
                    $validator->isUnique('img', $this->repository, 'img', '', $id);
                    $this->fileGuards($file);
                    $ancienneImage = $this->container->get('produit.img.basePath');
                    $ancienneImage .= $produit->getImg();
                    $produit->setImg($file->getClientFileName());
                    $file->moveTo($this->container->get('produit.img.basePath') . $file->getClientFileName());

                    if (!$file->isMoved()) {
                        $this->toaster->createToast("ERREUR : problème", Toaster::ERROR);
                        $this->redirect('admin.produit.update');
                    }
                    $this->deleteImage($ancienneImage);
                }
            }
            $this->manager->flush();
            $this->toaster->createToast('Modification enregistrée.', Toaster::SUCCESS);
            return $this->redirect('admin.produit.manage');
        }

        $ingredients = $this->manager->getRepository(Ingredient::class)->findAll();
        $categories = $this->manager->getRepository(Categorie::class)->findAll();
        $taxes = $this->manager->getRepository(Taxe::class)->findAll();
        $types = $this->manager->getRepository(TypeIngredient::class)->findAll();
        return $this->renderer->render('@produit/admin/updateProduit', [
            'produit' => $produit,
            'ingredients' => $ingredients,
            'categories' => $categories,
            'taxes' => $taxes,
            'types' => $types
        ]);
    }
    public function delete(ServerRequest $request): string
    {
        $id = $request->getAttribute('id');
        $produit = $this->repository->find($id);
        $imagePath = $this->container->get('produit.img.basePath');
        $imagePath .= $produit->getImg();
        $this->deleteImage($imagePath);
        $this->manager->remove($produit);
        $this->manager->flush();
        return "true";
    }

    public function deleteImage(string $path): void
    {
        unlink($path);
    }
}
