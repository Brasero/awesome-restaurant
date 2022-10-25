<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="taxe")
 */
class Taxe
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @var int
     */
    private int $id;

    /**
     * @ORM\Column(type="float", name="taux_taxe", nullable=false, unique=true)
     * @var float
     */
    private float $taux;

    /**
     * @ORM\OneToMany(targetEntity="Produit", mappedBy="taxe")
     */
    //private ArrayCollection $produits;


    /**
     * Constructor
     */
    public function __construct()
    {
        //$this->produits = new ArrayCollection();

    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getTaux(): float
    {
        return $this->taux;
    }

    /**
     * @param float $taux
     */
    public function setTaux($taux): void
    {
        $taux = str_replace(',', '.', $taux);
        $this->taux = floatval($taux);
    }


    /**
     * Add produit.
     *
     * @param Produit $produit
     *
     * @return Taxe
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
     * @return Collection
     */
    public function getProduits()
    {
        return $this->produits;
    }
}
