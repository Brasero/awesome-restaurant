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
    private string $password;

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
     * @ORM\Column(type="string", name="ville_adresse_user")
     * @var string
     */
    private string $ville;

    /**
     * @ORM\Column(type="string", name="cp_adresse_user")
     * @var string
     */
    private string $cp;


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
    public function setTelephone(string $telephone): void
    {
        $this->telephone = $telephone;
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
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
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

    /**
     * @return string
     */
    public function getVille(): string
    {
        return $this->ville;
    }

    /**
     * @param string $ville
     */
    public function setVille(string $ville): void
    {
        $this->ville = $ville;
    }

    /**
     * @return string
     */
    public function getCp(): string
    {
        return $this->cp;
    }

    /**
     * @param string $cp
     */
    public function setCp(string $cp): void
    {
        $this->cp = $cp;
    }










}
