<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @return Categorie
     */
    public function setNom(string $nom): self
    {
        $this->nom = strtolower(htmlentities($nom));
        return $this;
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
     * @return Categorie
     */
    public function setImg(string $img): self
    {
        $this->img = ($img);
        return $this;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->produits = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add produit.
     *
     * @param Produit $produit
     *
     * @return Categorie
     */
    public function addProduit(Produit $produit): self
    {
        $this->produits[] = $produit;

        return $this;
    }

    /**
     * Remove produit.
     *
     * @param Produit $produit
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeProduit(Produit $produit): bool
    {
        return $this->produits->removeElement($produit);
    }

    /**
     * Get produits.
     *
     * @return ArrayCollection
     */
    public function getProduits(): ArrayCollection
    {
        return $this->produits;
    }
}
