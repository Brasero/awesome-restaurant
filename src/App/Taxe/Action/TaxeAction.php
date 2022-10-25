<?php


namespace App\Taxe\Action;

use App\Entity\taxe;
use App\Framework\Toaster\Toaster;
use App\Framework\Validator\Validator;
use Doctrine\ORM\EntityManagerInterface;
use Framework\Renderer\RendererInterface;
use Framework\Router\RedirectTrait;
use Framework\Router\Router;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\ServerRequestInterface;

class TaxeAction
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

    public function __construct(
        RendererInterface      $renderer,
        Toaster                $toaster,
        Router                 $router,
        EntityManagerInterface $manager
    )
    {
        $this->toaster = $toaster;
        $this->router = $router;
        $this->manager = $manager;
        $this->renderer = $renderer;
    }

    /**
     * Valide les données de l'taxe et les enregistre en base de données
     * @param ServerRequest $request
     * @return MessageInterface
     */
    public function create(ServerRequest $request)
    {
        $data = $request->getParsedBody();

        // Validation des données
        $validator = new Validator($data);
        $validator->required('taux')

            ->intLength('taux', 0, 100)
            ->float('taux');

        // Si les données sont invalides
        $errors = $validator->getErrors();
        if (!empty($errors)) {
            foreach ($errors as $error) {
                $this->toaster->createToast($error, Toaster::ERROR);
            }
            return $this->redirect('admin.home');
        }

        $newtaxe = new taxe();
        $newtaxe->setTaux($data['taux']);

        // On verifie que le nom de la taxe n'existe pas déjà
        $taxes = $this->manager->getRepository(taxe::class)->findAll();
        foreach ($taxes as $taxe) {
            if ($taxe->getTaux() === $newtaxe->getTaux()) {
                $this->toaster->createToast('Ce taux existe déjà.', Toaster::ERROR);
                return $this->redirect('admin.home');
            }
        }

        // On converti le taux en float
        $taux = (int)$data['taux'] / 100;

        $newtaxe->setTaux($taux);

        // ToDo End

        // On enregistre la taxe en base de données
        $this->manager->persist($newtaxe);
        $this->manager->flush();

        // On affiche un message de succès
        $this->toaster->createToast('taxe créée avec succès', Toaster::SUCCESS);
        // On redirige vers la page d'accueil du dashboard
        return $this->redirect('admin.Taxe.show');
    }

    public function update(ServerRequest $request)
    {
        $method = $request->getMethod();
        $id = $request->getAttribute('id');
        $taxe = $this->manager->getRepository(taxe::class)->find($id);
        if ($method === 'POST') {
            $data = $request->getParsedBody();
            $taxe = $this->manager->getRepository(taxe::class)->find($id);
            $validator = new Validator($data);
            $errors = $validator->required('taux')
                ->intLength('taux', 0, 100)
                ->integer('taux')
                ->getErrors();
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    $this->toaster->createToast($error, Toaster::ERROR);
                }
                return $this->redirect('admin.Taxe.show');
            }

            $taxe->setTaux($data['taux']);
            $this->manager->flush();
            $this->toaster->createToast('taxe modifiée avec succès', Toaster::SUCCESS);
            return $this->redirect('admin.Taxe.show');
        }

        return $this->renderer->render('@taxe/update', [
            'taxe' => $taxe
        ]);
    }

    public function delete(ServerRequest $request)
    {
        return 'delete';
    }

    public function show(ServerRequestInterface $request): string
    {

        $taxes = $this->manager->getRepository(Taxe::class);
        return $this->renderer->render('@taxe/index', [
            'taxes' => $taxes
        ]);
    }

}
