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
    private $taxes;

    public function __construct(
        RendererInterface      $renderer,
        Toaster                $toaster,
        Router                 $router,
        EntityManagerInterface $manager
    ) {
        $this->toaster = $toaster;
        $this->router = $router;
        $this->manager = $manager;
        $this->renderer = $renderer;
        $this->taxes = $this->manager->getRepository(taxe::class)->findAll();
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
            return $this->redirect('admin.Taxe.show');
        }

        $newtaxe = new taxe();
        $newtaxe->setTaux($data['taux']);

        // On verifie que la la taxe n'existe pas déjà
        foreach ($this->taxes as $taxe) {
            if ($taxe->getTaux() === $newtaxe->getTaux()) {
                $this->toaster->createToast('Ce taux existe déjà.', Toaster::ERROR);
                return $this->redirect('admin.Taxe.show');
            }
        }
        $newtaxe->setTaux((float)$data['taux']);

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
        $data = $request->getParsedBody();
        $id = $data['id'];
        $taux = $data['Taux'];
        $taxe = $this->manager->getRepository(Taxe::class)->find($id);
        $taxe->setTaux($taux);
        foreach ($this->taxes as $ta) {
            if ($ta->getTaux() === $taxe->getTaux()&& $ta != $taxe) {
                $this->toaster->createToast('Ce taux existe déjà.', Toaster::ERROR);
                return $this->redirect('admin.Taxe.show');
            }
        }
        $this->toaster->createToast('Modification enregistrée', Toaster::SUCCESS);
        $this->manager->persist($taxe);
        $this->manager->flush();
        return $this->redirect('admin.Taxe.show');
    }



    public function delete(ServerRequest $request)
    {
        $id = $request->getAttribute('id');
        $taxe = $this->manager->find(Taxe::class, $id);
        $this->manager->remove($taxe);
        $this->manager->flush();
        $taxe = $this->manager->find(Taxe::class, $id);
        if (!is_null($taxe)) {
            return "false";
        }
        return "true";
    }

    public function show(ServerRequestInterface $request): string
    {

        $taxes = $this->manager->getRepository(Taxe::class)->findAll();
        return $this->renderer->render('@taxe/index', [
            'taxes' => $taxes
        ]);
    }
}
