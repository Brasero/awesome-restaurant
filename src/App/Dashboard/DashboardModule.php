<?php

namespace App\Dashboard;

use App\Entity\Offre;
use Doctrine\ORM\EntityManagerInterface;
use Framework\Module;
use Framework\Renderer\RendererInterface;
use Framework\Router\RedirectTrait;
use Framework\Router\Router;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ServerRequestInterface;

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
        $this->renderer = $container->get(RendererInterface::class);
        $this->router = $container->get(Router::class);
        $this->renderer->addPath('dashboard', __DIR__ . "/views");
        $adminprefix = $container->get('admin.prefix');
        $this->router->get($adminprefix.'/dashboard', [$this, 'index'], 'admin.home');
        $this->router->get(
            $adminprefix.'/dashboard/offre-padinated-{page:\d+}',
            [$this, 'index'],
            'admin.offre.paginated'
        );
        $this->manager = $container->get(EntityManagerInterface::class);
    }

    public function index(ServerRequestInterface $request): string
    {
        $page = $request->getAttribute('page', 1);
        $offrePerPage = 5;
        $repository = $this->manager->getRepository(Offre::class);
        $offres = $repository->findPaginated($page, $offrePerPage);
        $nbOffres = $repository->count([]);
        $nbOffres = $nbOffres == null && 1;
        $nbPagesOffre =  intval(ceil($nbOffres / $offrePerPage));

        return $this->renderer->render('@dashboard/index', [
            'offres' => $offres,
            'nbPagesOffre' => $nbPagesOffre,
        ]);
    }
}
