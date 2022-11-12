<?php
namespace App\User;

use App\Entity\User;
use App\Entity\Ville;
use Framework\Module;
use Framework\Router\Router;
use Framework\Toaster\Toaster;
use App\User\Action\AuthAction;
use App\User\Action\Admin\UserAction;
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
        $userAction = $container->get(UserAction::class);

        $router->get($prefix . '/connexion', [$authAction, 'connexion'], 'user.connexion');
        $router->post($prefix . '/connexion', [$authAction, 'connexion']);

        $router->get($prefix . '/inscription', [$authAction, 'inscription'], 'user.inscription');
        $router->post($prefix . "/inscription", [$authAction, 'inscription']);

        $router->get("/ajax/user/delete/{id:\d+}", [$userAction, "delete"], "user.delete");

        $router->get($prefix . '/espace', [$this, 'espace'], 'user.espace');

        if ($renderer instanceof TwigRenderer) {
            $renderer->getTwig()->addExtension($menuTwigExtension);
        }
        
        $this->router = $router;
        $this->manager = $manager;
        $this->router->get("/admin/user", [$this, "show"], "admin.user.show");
    }

    public function espace(): string
    {
        return $this->renderer->render('@user/profil');
    }

    public function show()
    {
        $repository = $this->manager->getRepository(User::class);
        $nbUsers = $repository->count([]);
        $users = $repository->findAll();
        return $this->renderer->render("@user/admin/show", [
            "nbUsers" => $nbUsers,
            "users" => $users,
        ]);
    }
}
