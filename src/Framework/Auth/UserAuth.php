<?php

namespace Framework\Auth;

use App\Entity\Adresse;
use App\Entity\User;
use App\Entity\Ville;
use Doctrine\ORM\EntityManagerInterface;
use Framework\Router\RedirectTrait;
use Framework\Session\SessionInterface;
use GuzzleHttp\Psr7\ServerRequest;

class UserAuth
{

    use RedirectTrait;

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
    public function connexion(string $email, string $mdp): bool
    {
        $user = $this->manager->getRepository(User::class)->findOneBy(["email" => $email]);
        // if ($user && password_verify($mdp, $user->getPassword()) 
        // or $this->isLogged()) {
        //     $this->session->set("auth", $user->getId());
        //     return true;
        // }
        if($user && password_verify($mdp, $user->getPassword()))  {
            return true;
        }
        return false;
    }

    /**
     * Vérifie si l'administrateur existe
     * @param string $username
     * @return bool
     */
    public function exist(string $email): bool
    {
        $email = $this->manager->getRepository(User::class)->findOneBy(['email' => $email]);
        return $email !== null;
    }

    /**
     * Deconnecte l'utilisateur
     *
     * @return void
     */
    public function logout(): void
    {
        $this->session->delete("auth");
    }

    /**
     * Vérifie si l'utilisateur est connecté
     *
     * @return boolean
     */
    public function isLogged(): bool
    {
        return $this->session->has("auth");
    }


    public function inscription(array $data)
    {
        
        $ville = $this->manager->getRepository(Ville::class)->findOneBy(["ville" => "Metz"]);
        
        $adresse = new Adresse();
        $user = new User();
        
        $adresse->setNumeroAdresse($data["numeroAdresse"]);
        $adresse->setAdressePrefix($data["prefixAdresse"]);
        $adresse->setAdresse($data["nameAdresse"]);
        $adresse->setComplementAdresse($data["adresseComplement"]);
        $adresse->setVille($ville);
        $adresse->setUser($user);
        $this->manager->persist($adresse);

        $user->setNom($data["nom"]);
        $user->setPrenom($data["prenom"]);
        $user->setTelephone($data["telephone"]);
        $user->setEmail($data["email"]);
        $user->setPassword($data["mdp"]);
        $user->setAdresse($adresse);
        $this->manager->persist($user);
                
        $this->manager->flush();
    }
}
