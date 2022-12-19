<?php

namespace Framework\Auth;

use App\Entity\Admin;
use Framework\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;

class AdminAuth
{

    /**
     * @var SessionInterface
     */
    private SessionInterface $session;
    private EntityManagerInterface $manager;

    /**
     * @param SessionInterface $session
     * @param EntityManagerInterface $manager
     */
    public function __construct(SessionInterface $session, EntityManagerInterface $manager)
    {
        $this->session = $session;
        $this->manager = $manager;
    }


    /**
     * Connecte l'administrateur, retourne true si la connexion a réussie
     * @param string $username Nom d'utilisateur
     * @param string $password  Mot de passe
     * @return bool
     */
    public function login(string $username, string $password): bool
    {
        $admin = $this->manager->getRepository(Admin::class)->findOneBy(['nom' => $username]);
        if ($admin
            && password_verify($password, $admin->getPassword())
            or (
                $this->isLogged()
                and $this->isAdmin()
                )
            ) {
            $this->session->set('auth', $admin);
            $this->setTimestamp();
            return true;
        }
        return false;
    }

    /**
     * Deconnecte l'administrateur et supprime le timestamp
     * @return void
     */
    public function logout(): void
    {
        $this->session->delete('auth');
        $this->session->delete('timestamp');
    }

    /**
     * Vérifie si l'administrateur est connecté
     * @return bool
     */
    public function isLogged(): bool
    {
        return $this->session->has('auth');
    }

    /**
     * Vérifie si l'utilisateur est bien un administrateur
     * @return bool
     */
    public function isAdmin(): bool
    {
        if ($this->isLogged()) {
            return $this->session->get('auth') instanceof Admin;
        }
        return false;
    }

    /**
     * Vérifie si l'administrateur existe
     * @param string $username
     * @return bool
     */
    public function exist(string $username): bool
    {
        $admin = $this->manager->getRepository(Admin::class)->findOneBy(['nom' => $username]);
        return $admin !== null;
    }

    /**
     * Défini le premier mot de passe de l'administrateur si il n'y en a pas encore
     * @param string $username Nom d'administrateur
     * @param string $password  Mot de passe
     * @return bool
     */
    public function setPassword(string $username, string $password): bool
    {
        $admin = $this->manager->getRepository(Admin::class)->findOneBy(['nom' => $username]);
        if ($admin->getPassword() === null) {
            $admin->setPassword($password);
            $this->manager->flush();
            return true;
        }
        return false;
    }

    /**
     * Vérifie si le timestamp est toujours valide
     * @return bool
     */
    public function checkTimestamp(): bool
    {
        $timestamp = $this->session->get('timestamp');
        if ($timestamp === null) {
            $this->logout();
            return false;
        } elseif ($timestamp > time()) {
            $this->setTimestamp();
            return true;
        }
        $this->logout();
        return false;
    }

    /**
     * Met à jour le timestamp
     * @return void
     */
    private function setTimestamp(): void
    {
        $time = 5*1000;
        $this->session->set('timestamp', time() + $time);
    }
}
