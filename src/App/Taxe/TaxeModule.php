<?php

namespace App\Taxe;

use App\Entity\Taxe;
use App\Framework\Toaster\Toaster;
use App\Framework\Validator\Validator;
use Doctrine\ORM\EntityManagerInterface;
use Framework\Module;
use Framework\Renderer\RendererInterface;
use Framework\Router\RedirectTrait;
use Framework\Router\Router;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class TaxeModule extends Module
{
    use RedirectTrait;

    private ContainerInterface $container;
    private Router $router;
    private RendererInterface $renderer;
    private EntityManagerInterface $manager;
    private Toaster $toaster;

    /**
     * @param ContainerInterface $container
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->router = $container->get(Router::class);
        $this->renderer = $container->get(RendererInterface::class);
        $this->manager = $container->get(EntityManagerInterface::class);
        $this->toaster = $container->get(Toaster::class);
        $this->renderer->addPath('taxe', __DIR__ . '/views');
        $this->router->get($container->get('admin.prefix') . '/taxe', [$this, 'index'], 'admin.taxe.index');
        $this->router->post($container->get('admin.prefix') . '/taxe/add', [$this, 'add'], 'admin.taxe.add');
    }

    public function index(): string
    {
        $taxes = $this->manager->getRepository(Taxe::class)->findAll();
        return $this->renderer->render('@taxe/index', [
            'taxes' => $taxes
        ]);
    }

    public function add(ServerRequest $request)
    {
        $data = $request->getParsedBody();
        $validator = new Validator($data);
        $errors = $validator->required('taux')
            ->intLenght('taux', 0, 100)
            ->float('taux')
            ->getErrors();

        if (!empty($errors)) {
            foreach ($errors as $error) {
                $this->toaster->createToast($error, Toaster::ERROR);
            }
            return $this->redirect('admin.taxe.index');
        }

        $taxe = new Taxe();
        $taxe->setTaux($data['taux']);
        $this->manager->persist($taxe);
        $this->manager->flush();
        $this->toaster->createToast('La taxe a bien été ajoutée', Toaster::SUCCESS);

        return $this->renderer->render('@taxe/index');
    }
}
