<?php

namespace App\Offre\Action;

use App\Entity\Offre;
use Doctrine\ORM\EntityRepository;
use Framework\Toaster\Toaster;
use Framework\Validator\Validator;
use Doctrine\ORM\EntityManagerInterface;
use Framework\Renderer\RendererInterface;
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

    /**
     * @var RendererInterface
     */
    private RendererInterface $renderer;

    /**
     * @var EntityRepository<Offre>
     */
    private EntityRepository $repository;

    public function __construct(
        RendererInterface $renderer,
        Toaster $toaster,
        Router $router,
        EntityManagerInterface $manager
    ) {
        $this->toaster = $toaster;
        $this->router = $router;
        $this->manager = $manager;
        $this->renderer = $renderer;
        $this->repository = $this->manager->getRepository(Offre::class);
    }

    /**
     * Valide les données de l'offre et les enregistre en base de données
     * @param ServerRequest $request
     * @return MessageInterface
     */
    public function create(ServerRequest $request)
    {
        $data = $request->getParsedBody();

        // Validation des données
        $validator = new Validator($data);
        $validator->required('nom', 'taux', 'date_debut', 'date_fin')
            ->isUnique('nom', $this->manager->getRepository(Offre::class))
            ->strLength('nom', 2, 255)
            ->strSize('nom', 2, 100)
            ->intLength('taux', 0, 100)
            ->checkInterval('date_debut', 'date_fin')
            ->float('taux');

        // Si les données sont invalides
        $errors = $validator->getErrors();
        if (!empty($errors)) {
            foreach ($errors as $error) {
                $this->toaster->createToast($error, Toaster::ERROR);
            }
            return $this->redirect('admin.home');
        }

        $newOffre = new Offre();
        $newOffre->setNom($data['nom']);


        $newOffre->setTaux($data['taux']);

        $newOffre->setDateDebut($data['date_debut']);
        $newOffre->setDateFin($data['date_fin']);

        // On enregistre l'offre en base de données
        $this->manager->persist($newOffre);
        $this->manager->flush();

        // On affiche un message de succès
        $this->toaster->createToast('Offre créée avec succès', Toaster::SUCCESS);
        // On redirige vers la page d'accueil du dashboard
        return $this->redirect('admin.home');
    }

    public function update(ServerRequest $request)
    {
        $method = $request->getMethod();
        $id = $request->getAttribute('id');
        $offre = $this->repository->find($id);
        if ($method === 'POST') {
            $data = $request->getParsedBody();
            $offre = $this->repository->find($id);
            $validator = new Validator($data);
            $errors = $validator->required('nom', 'taux', 'date_debut', 'date_fin')
                ->strLength('nom', 2, 255)
                ->intLength('taux', 0, 100)
                ->integer('taux')
                ->checkInterval('date_debut', 'date_fin')
                ->getErrors();
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    $this->toaster->createToast($error, Toaster::ERROR);
                }
                return $this->redirect('admin.home');
            }

            $offre->setNom($data['nom']);
            $offre->setTaux($data['taux']);
            $offre->setDateDebut($data['date_debut']);
            $offre->setDateFin($data['date_fin']);
            $this->manager->flush();
            $this->toaster->createToast('Offre modifiée avec succès', Toaster::SUCCESS);
            return $this->redirect('admin.home');
        }

        return $this->renderer->render('@offre/update', [
            'offre' => $offre
        ]);
    }

    public function delete(ServerRequest $request)
    {
        $id = $request->getAttribute('id');
        $offre = $this->repository->find($id);
        $this->manager->remove($offre);
        $this->manager->flush();
        $this->toaster->createToast('Offre supprimée avec succès', Toaster::SUCCESS);
        return $this->redirect('admin.home');
    }
}
