<?php

namespace App\Stats;

use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Framework\Module;
use Framework\Renderer\RendererInterface;
use Framework\Router\Router;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;

class StatsModule extends Module {

    public const DEFINITIONS = __DIR__.DIRECTORY_SEPARATOR."config.php";
    private Router $router;
    private RendererInterface $renderer;
    private EntityManagerInterface $manager;

    public function __construct(ContainerInterface $container)
    {
        $this->router = $container->get(Router::class);
        $this->renderer = $container->get(RendererInterface::class);
        $this->renderer->addPath("stats", __DIR__."/views");
        $manager = $container->get(EntityManagerInterface::class);
        $this->manager = $manager;
        
        $this->router->get("/admin/stats", [$this, "show"], "admin.stats.show");
    }

    public function show(ServerRequest $request) {
        $id = $request->getAttribute("id");
        $prods = $this->manager->find(Produit::class, $id);
        return $this->renderer->render("@stats/show", 
        [
            "prods" => $prods   
        ]
    );
    }

    public function manage(RequestInterface $request){
        $prodRepository = $this->manager->getRepository(Produit::class);
        $produits = $prodRepository->findAll();
        return $this->renderer->render("@stats/show", [
            "produits" => $produits,
        ]);
    }
}