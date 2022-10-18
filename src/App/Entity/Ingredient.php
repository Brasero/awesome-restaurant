<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IngredientRepository")
 * @ORM\Table(name="ingredient")
 */
class Ingredient
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", name="id")
     * @ORM\ManyToMany(targetEntity="Produit")
     * @var int
     */
    private int $ID;

    /**
     * @ORM\Column(type="string", name="nom_ingredient")
     * @var string
     */
    private string $nom;

    /**
     * @ORM\Column(type="float", name="prix_ingredient")
     * @var float
     */
    private float $prix;

    /**
     * @ORM\Column(type="boolean", name="dispo_ingredient")
     * @var bool
     */
    private bool $dispo;

    /**
     * @ORM\ManyToOne(targetEntity="TypeIngredient", inversedBy="ingredients")
     * @ORM\JoinTable(name="type_id")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @var TypeIngredient
     */
    private TypeIngredient $type;

    /**
     * @ORM\ManyToMany(targetEntity="Produit", mappedBy="ingredients")
     * @ORM\JoinTable(name="ingredient_produit")
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
     * @return float
     */
    public function getPrix(): float
    {
        return $this->prix;
    }

    /**
     * @param string $prix
     */
    public function setPrix(string $prix): void
    {
        $prix = str_replace(',', '.', $prix);
        $prix = floatval($prix);
        $this->prix = $prix;
    }

    /**
     * @return bool
     */
    public function isDispo(): bool
    {
        return $this->dispo;
    }

    /**
     * @param bool $dispo
     */
    public function setDispo(bool $dispo): void
    {
        $this->dispo = $dispo;
    }

    /**
     * @return TypeIngredient
     */
    public function getType(): TypeIngredient
    {
        return $this->type;
    }

    /**
     * @param TypeIngredient $type
     */
    public function setType(TypeIngredient $type): void
    {
        $this->type = $type;
    }

    /**
     * Get dispo.
     *
     * @return bool
     */
    public function getDispo()
    {
        return $this->dispo;
    }

    /**
     * Add produit.
     *
     * @param Produit $produit
     *
     * @return Ingredient
     */
    public function addProduit(Produit $produit)
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

    public function getProduits()
    {
        return $this->produits;
    }
}
