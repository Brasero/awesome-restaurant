<?php

namespace App\Entity;

use App\Entity\Offre;
use App\Entity\Categorie;
use App\Entity\Ingredient;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;

/**
 * @Entity
 * @Table(name="produit")
 */
class Produit
{
    /**
     * @Id
     * @Column(type="integer", name="id")
     * @GeneratedValue
     * @var int
     */
    private int $ID;

    /**
     * @Column(type="string", name="img_produit")
     * @var string
     */
    private string $img;

    /**
     * @Column(type="string", name="prix_produit")
     * @var string
     */
    private string $prix;

    /**
     * @ORM\ManyToOne(targetEntity="Offre", inversedBy="produits")
     * @ORM\JoinColumn(name="offre_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private ?Offre $offre;

    /**
     * @Column(type="string", name="nom_produit")
     */
    private string $nom;

    /**
     * @ORM\ManyToOne(targetEntity="Categorie", inversedBy="produits")
     * @ORM\JoinTable(name="categorie_id")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private Categorie $categorie;

    /**
     * @ORM\ManyToMany(targetEntity="Ingredient")
     * @ORM\JoinTable(name="ingredient_produit",
     * joinColumns={@ORM\JoinColumn(name="produit_id",referencedColumnName="id")},
     * inverseJoinColumns={@ORM\JoinColumn(name="ingredient_id", referencedColumnName="id")}
     * )
     */
    private $ingredients;

    /**
     * @ORM\ManyToOne(targetEntity="Taxe", inversedBy="produits")
     * @ORM\JoinColumn(name="taxe_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private Taxe $taxe;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ingredients = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function setPrix(string $prix)
    {
        $prix = str_replace(',', '.', $prix);
        $prix = floatval($prix);
        $this->prix = $prix;
    }

    public function setNom(string $nom)
    {
        $this->nom = strtolower($nom);
    }

    public function getPrix()
    {
        return $this->prix;
    }

    public function getImg()
    {
        return $this->img;
    }

    public function setImg(string $img)
    {
        $this->img = $img;
    }

    public function getOffre(): ?Offre
    {
        return $this->offre;
    }


    public function setOffre(Offre $offre = null): void
    {
        $this->offre = $offre;
    }

    public function getNom()
    {
        return ucfirst($this->nom);
    }

    public function getId()
    {
        return $this->ID;
    }

    public function hash(): void
    {
        $nom = strtolower(htmlentities(strip_tags($this->nom)));
        $this->setNom($nom);
    }

    /**
     * @return Categorie
     */
    public function getCategorie(): Categorie
    {
        return $this->categorie;
    }

    /**
     * @param Categorie $categorie
     */
    public function setCategorie(Categorie $categorie): self
    {
        $this->categorie = $categorie;
        return $this;
    }

    /**
     * @return Ingredient[]
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }

    /**
     * @param Ingredient $ingredient
     */
    public function setIngredients(Ingredient $ingredient): void
    {
        $this->ingredients[] = $ingredient;
    }

    /**
     * @return Taxe $taxe
     */
    public function getTaxe(): Taxe
    {
        return $this->taxe;
    }

    /**
     * @param Taxe $taxe
     */
    public function setTaxe(Taxe $taxe): self
    {
        $this->taxe = $taxe;
        return $this;
    }

    /**
     * Remove ingredient.
     *
     * @param \App\Entity\Ingredient $ingredient
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeIngredient(\App\Entity\Ingredient $ingredient)
    {
        return $this->ingredients->removeElement($ingredient);
    }
}
