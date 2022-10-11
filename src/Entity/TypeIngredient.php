<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
    private $ID;


    /**
     * @ORM\Column(type="string", name="nom_type_ingredient")
     * @var string
     */
    private $nom;


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

    /**
     * @return mixed
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }

    /**
     * @param $ingredients
     */
    public function setIngredients($ingredients): void
    {
        $this->ingredients = $ingredients;
    }
}
