<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="type_ingredient")
 */
class TypeIngredient
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", name="id")
     * @var int
     */
    private int $ID;


    /**
     * @ORM\Column(type="string", name="nom_type_ingredient")
     * @var string
     */
    private string $nom;


    /**
     * @ORM\OneToMany(targetEntity="Ingredient", mappedBy="TypeIngredient")
     */
    private $ingredients;



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

    public function getIngredients()
    {
        return $this->ingredients;
    }


    /**
     * Add ingredient.
     *
     * @param Ingredient $ingredient
     *
     * @return TypeIngredient
     */
    public function addIngredient(Ingredient $ingredient): self
    {
        $this->ingredients[] = $ingredient;

        return $this;
    }

    /**
     * Remove ingredient.
     *
     * @param Ingredient $ingredient
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeIngredient(Ingredient $ingredient): bool
    {
        return $this->ingredients->removeElement($ingredient);
    }
}
