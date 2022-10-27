<?php
namespace App\User;

use Framework\Module;
use Framework\Router\Router;
use Framework\Toaster\Toaster;
use App\User\Action\AuthAction;
use Doctrine\ORM\EntityManager;
use Framework\Renderer\TwigRenderer;
use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Framework\Renderer\RendererInterface;
use Framework\TwigExtension\MenuTwigExtension;

class UserModule extends Module
{


    const DEFINITIONS = __DIR__ . DIRECTORY_SEPARATOR . 'config.php';
    private Router $router;
    private RendererInterface $renderer;
    private EntityManagerInterface $manager;
    private Toaster $toaster;


    public function __construct(
        string $prefix,
        Router $router,
        RendererInterface $renderer,
        MenuTwigExtension $menuTwigExtension,
        EntityManagerInterface $manager,
        ContainerInterface $container
    ) {
        $renderer->addPath('user', __DIR__ . "/views");
        $this->renderer = $renderer;
        $router->get($prefix . '/connexion', [$this, 'connexion'], 'user.connexion');
        $router->get($prefix . '/inscription', [$this, 'inscription'], 'user.inscription');
        $router->get($prefix . '/espace', [$this, 'espace'], 'user.espace');

        if ($renderer instanceof TwigRenderer) {
            $renderer->getTwig()->addExtension($menuTwigExtension);
        }

        // $authAction = $container->get(AuthAction::class);
        $this->router = $router;
        $this->manager = $manager;
        $this->router->get("/admin/user", [$this, "show"], "admin.user.show");
        
    }


    public function __invoke(): string
    {
        return $this->connexion();
    }

    public function connexion(): string
    {
        return $this->renderer->render('@user/connexion');
    }

    public function inscription(): string
    {
        return $this->renderer->render('@user/inscription');
    }

    public function espace(): string
    {
        return $this->renderer->render('@user/espace');
    }

    public function show(){
        return $this->renderer->render("@user/admin/show");
    }
}
