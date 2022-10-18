<?php

namespace App\Offre;

use App\Offre\Action\OffreAction;
use Framework\Renderer\RendererInterface;
use Framework\Router\Router;
use Psr\Container\ContainerInterface;

class OffreModule
{

    public const DEFINITIONS = __DIR__ . DIRECTORY_SEPARATOR . 'config.php';

    /**
     * @var ContainerInterface
     */
    private ContainerInterface $container;
    private Router $router;

    public function __construct(ContainerInterface $container)
    {
        $offreAction = $container->get(OffreAction::class);
        $this->container = $container;
        $container->get(RendererInterface::class)->addPath('offre', __DIR__ . DIRECTORY_SEPARATOR . 'views');
        $adminprefix = $container->get('admin.prefix');
        $this->router = $container->get(Router::class);
        $this->router->post(
            $adminprefix . '/dashboard/addoffre',
            [$offreAction, 'create'],
            'admin.offre.add'
        );
        $this->router->get(
            $adminprefix . '/dashboard/offre-update-{id:\d+}',
            [$offreAction, 'update'],
            'admin.offre.update'
        );
        $this->router->get(
            $adminprefix . '/offre/delete/{id:\d+}',
            [$offreAction, 'delete'],
            'admin.offre.delete'
        );
        $this->router->post(
            $adminprefix . '/dashboard/offre-update-{id:\d+}',
            [$offreAction, 'update']
        );
    }
}
