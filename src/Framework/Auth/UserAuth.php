<?php

namespace Framework\Auth;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Framework\Session\SessionInterface;
use GuzzleHttp\Psr7\ServerRequest;

class UserAuth {

    private SessionInterface $session;
    private EntityManagerInterface $manager;

    public function __construct(SessionInterface $session, EntityManagerInterface $manager)
    {
        $this->session = $session;
        $this->manager = $manager;
    }

    /**
     * Connecte l'utilisateur avec email + mdp
     *
     * @param string $email
     * @param string $mdp
     * @return boolean
     */
    public function login(string $email, string $mdp): bool {
        $user = $this->manager->getRepository(User::class)->findOneBy(["email" => $email]);
        if ($user && password_verify($mdp, $user->getPassword()) or $this->isLogged()) {
            $this->session->set("auth", $user->getId());
            return true;
        }
        return false;
    }

    /**
     * Deconnecte l'utilisateur
     *
     * @return void
     */
    public function logout(): void {
        $this->session->delete("auth");
    }

    /**
     * Vérifie si l'utilisateur est connecté
     *
     * @return boolean
     */
    public function isLogged(): bool {
        return $this->session->has("auth");
    }


    public function register(ServerRequest $request) {

        // $user = $this->manager->getRepository(User::class)->findAll();

        // if(){
        //     $this->manager->flush();
        //     return true;
        // }
        // return false;
        $user = $request->getParsedBody();
        $register = new User();
        $register->setNom($user["nom"]);
        $register->setPrenom($user["prenom"]);
        $register->setTelephone($user["telephone"]);
        $register->setEmail($user["email"]);
        $register->setPassword($user["password"]);
        $register->setNumeroAdresse($user["numeroAdresse"]);
        $register->setAdresse($user["nameAdresse"]);
        $register->setComplementAdresse($user["adresseComplement"]);
        $register->setVille($user["adresseVille"]);
        $register->setCp($user["adresseCp"]);
        $this->manager->persist($register);
        $this->manager->flush();
    }
}