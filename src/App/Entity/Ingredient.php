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
     * @return Ingredient
     */
    public function setNom(string $nom): self
    {
        $this->nom = strtolower(htmlentities($nom));
        return $this;
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
     * @return Ingredient
     */
    public function setPrix(string $prix): self
    {
        $prix = str_replace(',', '.', $prix);
        $prix = floatval($prix);
        $this->prix = $prix;
        return $this;
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
     * @return Ingredient
     */
    public function setDispo(bool $dispo): self
    {
        $this->dispo = $dispo;
        return $this;
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
    public function setType(TypeIngredient $type): self
    {
        $this->type = $type;
        return $this;
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
}
