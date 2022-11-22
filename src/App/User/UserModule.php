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
        $authAction = $container->get(AuthAction::class);

        $router->get($prefix . '/connexion', [$authAction, 'connexion'], 'user.connexion');
        $router->post($prefix . '/connexion', [$authAction, 'connexion']);

        $router->get($prefix . '/inscription', [$authAction, 'inscription'], 'user.inscription');
        $router->post($prefix . "/inscription", [$authAction, 'inscription']);

        $router->get($prefix . '/espace', [$this, 'espace'], 'user.espace');
        $router->get($prefix . '/paramProfil', [$this, 'paramProfil'], 'user.paramProfil');
        $router->get($prefix . '/adresse', [$this, 'adresse'], 'user.adresse');
        $router->get($prefix . '/aide', [$this, 'aide'], 'user.aide');

        if ($renderer instanceof TwigRenderer) {
            $renderer->getTwig()->addExtension($menuTwigExtension);
        }
        
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
        return $this->renderer->render('@user/profil');
    }

    public function paramProfil(): string
    {
        return $this->renderer->render('@user/paramProfil');
    }

    public function adresse(): string
    {
        return $this->renderer->render('@user/adresse');
    }
    public function aide(): string
    {
        return $this->renderer->render('@user/aide');
    }

    public function show()
    {
        return $this->renderer->render("@user/admin/show");
    }
}
