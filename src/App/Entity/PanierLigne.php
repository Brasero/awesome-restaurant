<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
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
     * @ORM\ManyToMany(targetEntity="Ingredient", inversedBy="panier_ligne")
     * @ORM\JoinTable(name="panier_ligne_ingredient",
     *     joinColumns={@ORM\JoinColumn(name="panier_ligne_id", referencedColumnName="id_panier_ligne")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="ingredient_id", referencedColumnName="id")}
     *     )
     * @var Collection
     */
    private $ingredients;

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
     * @return PanierLigne
     */
    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Set panier.
     *
     * @param Panier $panier
     *
     * @return PanierLigne
     */
    public function setPanier(Panier $panier): self
    {
        $this->panier = $panier;

        return $this;
    }

    /**
     * Get panier.
     *
     * @return Panier
     */
    public function getPanier(): Panier
    {
        return $this->panier;
    }

    /**
     * Set produit.
     *
     * @param Produit $produit
     *
     * @return PanierLigne
     */
    public function setProduit(Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * Get produit.
     *
     * @return Produit
     */
    public function getProduit(): Produit
    {
        return $this->produit;
    }

    public function addIngredient(Ingredient $ingredient): self
    {
        $this->ingredients[] = $ingredient;

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): self
    {
        $this->ingredients->removeElement($ingredient);

        return $this;
    }

    public function getIngredients()
    {
        return $this->ingredients;
    }
}
