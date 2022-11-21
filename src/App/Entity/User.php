<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue
     * @var int
     */
    private int $id;

    /**
     * @ORM\Column(type="string", name="nom_user")
     * @var string
     */
    private string $nom;

    /**
     * @ORM\Column(type="string", name="prenom_user")
     * @var string
     */
    private string $prenom;

    /**
     * @ORM\Column(type="string", name="telephone_user")
     * @var string
     */
    private string $telephone;

    /**
     * @ORM\Column(type="string", name="email_user")
     * @var string
     */
    private string $email;

    /**
     * @ORM\Column(type="string", name="password_user")
     * @var string
     */
    private string $mdp;

    

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Adresse", mappedBy="user")
     * @ORM\JoinColumn(name="id_adresse", onDelete="CASCADE")
     */
    private $adresse;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Panier", mappedBy="user")
     */
    private $panier;


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getPrenom(): string
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    /**
     * @return string
     */
    public function getTelephone(): string
    {
        return $this->telephone;
    }

    /**
     * @param string $telephone
     */
    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->mdp;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $mdp): void
    {
        $this->mdp = password_hash($mdp, PASSWORD_BCRYPT);
    }

    

    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param Adresse $adresse
     */
    public function setAdresse(Adresse $adresse): self
    {
        $this->adresse = $adresse;
        return $this;
    }

    /**
     * Set mdp.
     *
     * @param string $mdp
     *
     * @return User
     */
    public function setMdp($mdp)
    {
        $this->mdp = $mdp;

        return $this;
    }

    /**
     * Get mdp.
     *
     * @return string
     */
    public function getMdp()
    {
        return $this->mdp;
    }

    /**
     * Set panier.
     *
     * @param \App\Entity\Panier|null $panier
     *
     * @return User
     */
    public function setPanier(\App\Entity\Panier $panier = null)
    {
        $this->panier = $panier;

        return $this;
    }

    /**
     * Get panier.
     *
     * @return \App\Entity\Panier|null
     */
    public function getPanier()
    {
        return $this->panier;
    }
}
