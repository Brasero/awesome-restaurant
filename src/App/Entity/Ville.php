<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="ville")
 */
class Ville
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue
     * @var int
     */
    private int $id;

    /**
     * @ORM\Column(type="string", name="nom_ville")
     * @var string
     */
    private string $ville;

    /**
     * @ORM\Column(type="string", name="cp_ville")
     * @var string
     */
    private string $cp;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Adresse", mappedBy="ville")
     *
     */
    private $adresses;

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
    public function getVille(): string
    {
        return $this->ville;
    }


    /**
     * @return string
     */
    public function getCp(): string
    {
        return $this->cp;
    }

    public function getAdresses()
    {
        return $this->adresses;
    }

    /**
     * @param Adresse $adresses
     */
    public function setAdresses(Adresse $adresses): self
    {
        $this->adresses = $adresses;
        return $this;
    }
}
