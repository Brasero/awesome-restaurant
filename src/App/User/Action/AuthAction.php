<?php

namespace App\User\Action;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Framework\Auth\UserAuth;
use Framework\Router\Router;
use Framework\Toaster\Toaster;
use Framework\Validator\Validator;
use GuzzleHttp\Psr7\ServerRequest;
use Framework\Router\RedirectTrait;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\MessageInterface;
use Framework\Renderer\RendererInterface;

class AuthAction
{

    use RedirectTrait;

    private ContainerInterface $container;
    private Toaster $toaster;
    private Router $router;
    private RendererInterface $renderer;
    private EntityManagerInterface $manager;
    

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->toaster = $this->container->get(Toaster::class);
        $this->router = $this->container->get(Router::class);
        $this->renderer = $this->container->get(RendererInterface::class);
        $this->manager = $this->container->get(EntityManagerInterface::class);
    }

    /**
     * Connexion de l'utilisateur
     *
     * @param ServerRequest $request
     * @return void
     */
    public function connexion(ServerRequest $request)
    {
        $method = $request->getMethod();
        if ($method === "POST") {
            $auth = $this->container->get(UserAuth::class);
            $params = $request->getParsedBody();
            $validator = new Validator($params);
            $errors = $validator
                    ->required("email", "mdp")
                    ->email("email")
                    ->getErrors();

            if (!empty($errors)) {
                foreach ($errors as $error) {
                    $this->toaster->createToast($error, Toaster::ERROR);
                }
                return $this->redirect('user.connexion');
            }

            $email = $params["email"];
            $mdp = $params["mdp"];
            if ($auth->connexion($email, $mdp)) {
                $this->toaster->createToast("Vous êtes connecté", Toaster::SUCCESS);
                return $this->redirect("produit.carte");
            }

            $this->toaster->createToast("Indentifiant ou mot de passe inconnu", Toaster::ERROR);
            return $this->redirect("user.connexion");
        }
        return $this->renderer->render("@user/connexion");

    }

    /**
     * Inscription de l'utilisateur
     *
     * @param ServerRequest $request
     * @return void
     */
    public function inscription(ServerRequest $request)
    {
        $method = $request->getMethod();
        if ($method === "POST") {

            $params = $request->getParsedBody();
            $auth = $this->container->get(UserAuth::class);
            $repository = $this->manager->getRepository(User::class);

            $validator = new Validator($params);
            $errors = $validator
                        ->required("nom", "prenom", "telephone", "email", "mdp", "numeroAdresse", "prefixAdresse", "nameAdresse", "email_confirm", "mdp_confirm")
                        ->strLength("mdp", 6, 50)
                        ->strLength("telephone", 10, 10)
                        ->email("email")
                        ->isUnique("email", $repository, "email", "Email déjà existant")
                        ->isUnique("telephone", $repository, "telephone", "Numéro de téléphone déjà existant")
                        ->confirm("mdp")
                        ->confirm("email")
                        ->getErrors();

            if (!empty($errors)) {
                foreach ($errors as $error) {
                    $this->toaster->createToast($error, Toaster::ERROR);
                }
                return $this->redirect("user.inscription");
            }
            
            /** Enregistre en bdd avec la fonction inscription */
            $auth->inscription($params);
            $this->toaster->createToast("Compte crée.", Toaster::SUCCESS);
            return $this->redirect("user.connexion");
            
        }
        
        return $this->renderer->render("@user/inscription");
    }

    /**
     * Deconnection de l'utilisateur
     *
     * @return MessageInterface
     */
    public function logout(): MessageInterface
    {
        $auth = $this->container->get(UserAuth::class);
        $auth->logout();
        $this->toaster->createToast("Vous êtes déconnecté", Toaster::SUCCESS);
        return $this->redirect("user.connexion");
    }
}
