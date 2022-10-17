<?php

namespace App\Dashboard;

use App\Dashboard\Action\OffreAction;
use App\Entity\Offre;
use Doctrine\ORM\EntityManagerInterface;
use Framework\Module;
use Framework\Renderer\RendererInterface;
use Framework\Router\RedirectTrait;
use Framework\Router\Router;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class DashboardModule extends Module
{
    use RedirectTrait;

    const DEFINITIONS = __DIR__ . DIRECTORY_SEPARATOR . 'config.php';

    /**
     *
     * @var RendererInterface
     */
    private RendererInterface $renderer;

    /**
     *
     * @var Router
     */
    private Router $router;
    private EntityManagerInterface $manager;

    /**
     * @param ContainerInterface $container
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(ContainerInterface $container)
    {
        $offreAction = $container->get(OffreAction::class);
        $this->renderer = $container->get(RendererInterface::class);
        $this->router = $container->get(Router::class);
        $this->renderer->addPath('dashboard', __DIR__ . "/views");
        $adminprefix = $container->get('admin.prefix');
        $this->router->get($adminprefix.'/dashboard', [$this, 'index'], 'admin.home');
        $this->router->post($adminprefix . '/dashboard/addoffre', [$offreAction, 'create'], 'admin.add.offre');
        $this->manager = $container->get(EntityManagerInterface::class);
    }

    public function index(): string
    {
        $repository = $this->manager->getRepository(Offre::class);
        $offres = $repository->findAll();
        return $this->renderer->render('@dashboard/index', [
            'offres' => $offres
        ]);
    }
}
