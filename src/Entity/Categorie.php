<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;

/**
 * @Entity
 * @Table(name="categorie")
 */
class Categorie
{
    /**
     * @Id
     * @Column(type="integer", name="id")
     * @GeneratedValue
     * @var int
     */
    private int $ID;

    /**
     * @Column(type="string", name="nom_categorie")
     */
    private string $nom;

    /**
     * @Column(type="string", name="img_categorie")
     * @var string
     */
    private string $img;

    /**
     * @ORM\OneToMany(targetEntity="Produit", mappedBy="categorie")
     */
    private $produits;

    /**
     * @return int
     */
    public function getID(): int
    {
        return $this->ID;
    }

    /**
     * @return string
     */
    public function getNom(): string
    {
        return ucfirst(html_entity_decode($this->nom));
    }

    /**
     * @param string $nom
     */
    public function setNom(string $nom): void
    {
        $this->nom = strtolower(htmlentities($nom));
    }

    /**
     * @return string
     */
    public function getImg(): string
    {
        return $this->img;
    }

    /**
     * @param string $img
     */
    public function setImg(string $img): void
    {
        $this->img = ($img);
    }
}
