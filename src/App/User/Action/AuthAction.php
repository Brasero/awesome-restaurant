<?php

namespace App\User\Action;

use Framework\Auth\UserAuth;
use Framework\Renderer\RendererInterface;
use Framework\Router\Router;
use Framework\Toaster\Toaster;
use Framework\Router\RedirectTrait;
use Framework\Validator\Validator;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\MessageInterface;

class AuthAction {

    use RedirectTrait;

    private ContainerInterface $container;
    private Toaster $toaster;
    private Router $router;
    private RendererInterface $renderer;
    

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->toaster = $this->container->get(Toaster::class);
        $this->router = $this->container->get(Router::class);
        $this->renderer = $this->container->get(Renderer::class);
    }

    /**
     * Connexion de l'utilisateur
     *
     * @param ServerRequest $request
     * @return void
     */
    public function login(ServerRequest $request){
        $method = $request->getMethod();
        if($method === "POST"){
            $auth = $this->container->get(UserAuth::class);
            $params = $request->getParsedBody();
            $validator = new Validator($params);
            $errors = $validator
                    ->required("email","mdp")
                    ->getErrors();
            if(!empty($errors)){
                foreach($errors as $error){
                    $this->toaster->createToast($error, Toaster::ERROR);
                }
            }
            $email = $params["email"] ?? null;
            $mdp = $params["mdp"] ?? null;
            if($auth->login($email,$mdp)){
                $this->toaster->createToast("Vous êtes connecté", Toaster::SUCCESS);
                return $this->redirect("user.espace");
            }
            $this->toaster->createToast("Indentifiant ou mot de passe inconnu", Toaster::ERROR);

        }
    }

    /**
     * Inscription de l'utilisateur
     *
     * @param ServerRequest $request
     * @return void
     */
    public function register(ServerRequest $request){

        $method = $request->getMethod();
        if($method === "POST"){
            $auth = $this->container->get(UserAuth::class);
            $params = $request->getParsedBody();
            $validator = new Validator($params);
            $errors = $validator
                        ->required("nom","prenom","tel","email","mdp","numeroAdresse","prefixAdresse","nameAdresse","adresseComplement","adresseVille","adresseCp")
                        ->strLength("mdp", 6, 50)
                        ->confirm("mdp","email")
                        ->getErrors();

            if(!empty($errors)){
                foreach ($errors as $error){
                    $this->toaster->createToast($error, Toaster::ERROR);
                }
            }

            $nom = $params["nom"] ?? null;
            $prenom = $params["prenom"] ?? null;
            $telephone = $params["telephone"] ?? null;
            $email = $params["email"] ?? null;
            $mdp = $params["mdp"] ?? null;
            $numeroAdresse = $params["numeroAdresse"] ?? null;
            $adresse = $params["nameAdresse"] ?? null;
            $complementAdresse = $params["adresseComplement"] ?? null;
            $ville = $params["adresseVille"] ?? null;
            $cp = $params["adresseCp"] ?? null;
            if($auth->register($params)){

            }

            $this->toaster->createToast("Compte crée.", Toaster::SUCCESS);
            return $this->redirect("user.auth");
        }
    }

    /**
     * Deconnection de l'utilisateur
     *
     * @return MessageInterface
     */
    public function logout(): MessageInterface {
        $auth = $this->container->get(UserAuth::class);
        $auth->logout();
        $this->toaster->createToast("Vous êtes déconnecté", Toaster::SUCCESS);
        return $this->redirect("user.auth");
    }
}