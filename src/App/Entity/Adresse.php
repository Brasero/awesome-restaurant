<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="adresse")
 */
class Adresse
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue
     * @var int
     */
    private int $id;

/**
     * @ORM\Column(type="string", name="numero_adresse_user")
     * @var string
     */
    private string $numeroAdresse;

    /**
     * @ORM\Column(type="string", name="prefix_adresse_user")
     * @var string
     */
    private string $adressePrefix;

    /**
     * @ORM\Column(type="string", name="name_adresse_user")
     * @var string
     */
    private string $adresse;

    /**
     * @ORM\Column(type="string", name="complement_adresse_user", nullable="true")
     * @var string
     */
    private string $complementAdresse;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="adresses")
     * @ORM\JoinColumn(name="user_id", onDelete="CASCADE")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ville", inversedBy="adresses")
     *
     */
    private $ville;


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
    public function getNumeroAdresse(): string
    {
        return $this->numeroAdresse;
    }

    /**
     * @param string $numeroAdresse
     */
    public function setNumeroAdresse(string $numeroAdresse): void
    {
        $this->numeroAdresse = $numeroAdresse;
    }

    /**
     * @return string
     */
    public function getAdressePrefix(): string
    {
        return $this->adressePrefix;
    }

    /**
     * @param string $adressePrefix
     */
    public function setAdressePrefix(string $adressePrefix): void
    {
        $this->adressePrefix = $adressePrefix;
    }

    /**
     * @return string
     */
    public function getAdresse(): string
    {
        return $this->adresse;
    }

    /**
     * @param string $adresse
     */
    public function setAdresse(string $adresse): void
    {
        $this->adresse = $adresse;
    }

    /**
     * @return string
     */
    public function getComplementAdresse(): string
    {
        return $this->complementAdresse;
    }

    /**
     * @param string $complementAdresse
     */
    public function setComplementAdresse(string $complementAdresse): void
    {
        $this->complementAdresse = $complementAdresse;
    }

    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }
    
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * @param Ville $ville
     */
    public function setVille(Ville $ville): self
    {
        $this->ville = $ville;
        return $this;
    }
}
