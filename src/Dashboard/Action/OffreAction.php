<?php

namespace App\Dashboard\Action;

use App\Entity\Offre;
use App\Framework\Toaster\Toaster;
use App\Framework\Validator\Validator;
use Doctrine\ORM\EntityManagerInterface;
use Framework\Router\RedirectTrait;
use Framework\Router\Router;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\MessageInterface;

class OffreAction
{
    use RedirectTrait;

    /**
     * @var Toaster
     */
    private Toaster $toaster;

    /**
     * @var Router
     */
    private Router $router;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;

    public function __construct(Toaster $toaster, Router $router, EntityManagerInterface $manager)
    {
        $this->toaster = $toaster;
        $this->router = $router;
        $this->manager = $manager;
    }

    public function show(ServerRequest $request)
    {
        return 'show';
    }

    /**
     * @param ServerRequest $request
     * @return MessageInterface
     */
    public function create(ServerRequest $request)
    {
        $data = $request->getParsedBody();
        $validator = new Validator($data);
        $validator->required('nom', 'taux', 'date_debut', 'date_fin')
            ->strLenght('nom', 2, 255)
            ->intLenght('taux', 0, 100)
            ->integer('taux');
        $errors = $validator->getErrors();
        if (!empty($errors)) {
            foreach ($errors as $error) {
                $this->toaster->createToast($error->string(), Toaster::ERROR);
            }
            return $this->redirect('admin.home');
        }

        $newOffre = new Offre();
        $newOffre->setNom($data['nom']);
        $newOffre->setTaux($data['taux']);
        $newOffre->setDateDebut($data['date_debut']);
        $newOffre->setDateFin($data['date_fin']);
        $offres = $this->manager->getRepository(Offre::class)->findAll();
        foreach ($offres as $offre) {
            if ($offre->getNom() === $newOffre->getNom()) {
                $this->toaster->createToast('Une offre porte déjà ce nom', Toaster::ERROR);
                return $this->redirect('admin.home');
            }
        }
        $this->manager->persist($newOffre);
        $this->manager->flush();
        $this->toaster->createToast('Offre créée avec succès', Toaster::SUCCESS);
        return $this->redirect('admin.home');
    }

    public function update(ServerRequest $request)
    {
        return 'update';
    }

    public function delete(ServerRequest $request)
    {
        return 'delete';
    }
}
