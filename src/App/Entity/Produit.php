<?php

namespace App\Entity;

use App\Entity\Offre;
use App\Entity\Categorie;
use App\Entity\Ingredient;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    private $categorie;

    /**
     * @ORM\ManyToMany(targetEntity="Ingredient")
     * @ORM\JoinTable(name="ingredient_produit",
     * joinColumns={@ORM\JoinColumn(name="produit_id",referencedColumnName="id", onDelete="CASCADE")},
     * inverseJoinColumns={@ORM\JoinColumn(name="ingredient_id", referencedColumnName="id")}
     * )
     */
    private $ingredients;

    /**
     * @ORM\ManyToOne(targetEntity="Taxe", inversedBy="produits")
     * @ORM\JoinColumn(name="taxe_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $taxe;

    /**
     * @Column(type="string", name="description_produit", nullable="true")
     * @var string|null
     */
    private ?string $description = null;


    /**
     * @ORM\OneToMany(targetEntity="PanierLigne", mappedBy="produit")
     * @ORM\JoinTable(name="panier_ligne")
     */
    private $panier_ligne;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
    }

    public function setPrix(string $prix): self
    {
        $prix = str_replace(',', '.', $prix);
        $prix = floatval($prix);
        $this->prix = $prix;
        return $this;
    }

    public function setNom(string $nom): self
    {
        $this->nom = htmlentities(strtolower($nom));
        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->description = htmlentities(strtolower($description));
        return $this;
    }

    public function getPrix()
    {
        return $this->prix;
    }

    public function getImg()
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;
        return $this;
    }

    public function getOffre(): ?Offre
    {
        return $this->offre;
    }


    public function setOffre(Offre $offre = null): self
    {
        $this->offre = $offre;
        return $this;
    }

    public function getNom()
    {
        return ucfirst(html_entity_decode($this->nom));
    }

    public function getDescription()
    {
        return ucfirst(html_entity_decode($this->description));
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
     * @return Produit
     */
    public function setCategorie(Categorie $categorie): self
    {
        $this->categorie = $categorie;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getIngredients(): ArrayCollection
    {
        return $this->ingredients;
    }

    /**
     * @param Ingredient $ingredient
     */
    public function setIngredients(Ingredient $ingredient): self
    {
        $this->ingredients[] = $ingredient;
        return $this;
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

    /**
     * Add ingredient.
     *
     * @param \App\Entity\Ingredient $ingredient
     *
     * @return Produit
     */
    public function addIngredient(\App\Entity\Ingredient $ingredient)
    {
        $this->ingredients[] = $ingredient;

        return $this;
    }

    /**
     * Add panierLigne.
     *
     * @param PanierLigne $panierLigne
     *
     * @return Produit
     */
    public function addPanierLigne(PanierLigne $panierLigne)
    {
        $this->panier_ligne[] = $panierLigne;

        return $this;
    }

    /**
     * Remove panierLigne.
     *
     * @param PanierLigne $panierLigne
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removePanierLigne(PanierLigne $panierLigne)
    {
        return $this->panier_ligne->removeElement($panierLigne);
    }

    /**
     * Get panierLigne.
     *
     * @return Collection
     */
    public function getPanierLigne()
    {
        return $this->panier_ligne;
    }
}
