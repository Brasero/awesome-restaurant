<?php

namespace App\Entity;

use App\Entity\Panier;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="panier_ligne")
 */
class PanierLigne
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id_panier_ligne")
     * @ORM\GeneratedValue
     * @var int
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity="Panier", inversedBy="panier_ligne")
     * @ORM\JoinColumn(name="panier_id", referencedColumnName="id_panier")
     */
    private Panier $panier;

    /**
     * @ORM\ManyToOne(targetEntity="Produit", inversedBy="panier_ligne")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @ORM\JoinTable(name="produit_id")
     */
    private Produit $produit;


    /**
     * @ORM\Column(type="integer", name="quantite")
     * @var int
     */
    private int $quantite;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getQuantite(): int
    {
        return $this->quantite;
    }

    /**
     * @param int $quantite
     */
    public function setQuantite(int $quantite): void
    {
        $this->quantite = $quantite;
    }

    /**
     * Set panier.
     *
     * @param int $panier
     *
     * @return PanierLigne
     */
    public function setPanier($panier)
    {
        $this->panier = $panier;

        return $this;
    }

    /**
     * Get panier.
     *
     * @return int
     */
    public function getPanier()
    {
        return $this->panier;
    }

    /**
     * Set produit.
     *
     * @param int $produit
     *
     * @return PanierLigne
     */
    public function setProduit($produit)
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * Get produit.
     *
     * @return int
     */
    public function getProduit()
    {
        return $this->produit;
    }
}
