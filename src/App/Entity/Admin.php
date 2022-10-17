<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="administrateur")
 */
class Admin
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue
     * @var int
     */
    private int $id;

    /**
     * @ORM\Column(type="string", name="nom_admin")
     * @var string
     */
    private string $nom;

    /**
     * @ORM\Column(type="string", name="password_admin", length=255, nullable=true)
     * @var string
     */
    private string $password;

    /**
     * @ORM\Column(type="string", name="email_admin")
     * @var string
     */
    private string $email;

    /**
     * @ORM\Column(type="string", name="telephone_admin")
     * @return string
     */
    private string $telephone;

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
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password ?? null;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
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
}
