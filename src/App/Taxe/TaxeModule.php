<?php

namespace App\Taxe;

use App\Entity\Taxe;
use App\Taxe\Action\TaxeAction;
use Doctrine\ORM\EntityManagerInterface;
use Framework\Module;
use Framework\Renderer\RendererInterface;
use Framework\Router\Router;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

class TaxeModule extends Module
{
    public const DEFINITIONS = __DIR__ . DIRECTORY_SEPARATOR . 'config.php';

    private ContainerInterface $container;
    private Router $router;



    /**
     * @param ContainerInterface $container
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(ContainerInterface $container)
    {
        $TaxeAction = $container->get(TaxeAction::class);
        $this->container = $container;
        $container->get(RendererInterface::class)->addPath('taxe', __DIR__ . DIRECTORY_SEPARATOR . 'views');
        $adminprefix = $container->get('admin.prefix');
        $this->router = $container->get(Router::class);


        $this->router->get(
            $adminprefix . '/dashboard/Taxe',
            [$TaxeAction, 'show'],
            'admin.Taxe.show'
        );
        $this->router->post(
            $adminprefix . '/dashboard/addTaxe',
            [$TaxeAction, 'create'],
            'admin.Taxe.add'
        );

        $this->router->post(
            $adminprefix . '/dashboard/TaxeUpdate',
            [$TaxeAction, 'update'],
            'admin.Taxe.update'
        );
        
        $this->router->get(
            '/ajax/Taxe/delete/{id:[0-9]+}',
            [$TaxeAction, 'delete'],
            'admin.Taxe.delete'
        );
    }
}
