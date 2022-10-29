<?php

namespace App\Stats;

use App\Entity\Ingredient;
use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Framework\Module;
use Framework\Renderer\RendererInterface;
use Framework\Router\Router;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;

class StatsModule extends Module
{

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

    public function show(ServerRequest $request)
    {
        $repositoryIngredient = $this->manager->getRepository(Ingredient::class);
        $nbIngredient = $repositoryIngredient->count([]);

        return $this->renderer->render(
            "@stats/show",
            [
            "ingredients" => $nbIngredient
            ]
        );
    }
}
