<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
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
     * @Column(type="integer")
     */
    private ?int $ID_offre;

    /**
     * @Column(type="string", name="nom_produit")
     */
    private string $nom;

    /**
     * @ORM\ManyToOne(targetEntity="Categorie")
     */
    private Categorie $categorie;

    /**
     * @ORM\ManyToMany(targetEntity="Ingredient")
     * @ORM\JoinTable(name="ingredient_produit")
     * @var Ingredient[]
     */
    private array $ingredient;

    /**
     * @Column(type="integer")
     */
    private int $ID_taxe;


    public function setPrix(string $prix)
    {
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

    public function getId_offre()
    {
        return $this->ID_offre;
    }

    public function setId_taxe(int $ID_taxe)
    {
        $this->ID_taxe = $ID_taxe;
    }

    public function setId_offre($ID_offre)
    {
        $this->ID_offre = $ID_offre;
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

    public function getId_taxe()
    {
        return $this->ID_taxe;
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
    public function setCategorie(Categorie $categorie): void
    {
        $this->categorie = $categorie;
    }

    /**
     * @return Ingredient[]
     */
    public function getIngredient(): array
    {
        return $this->ingredient;
    }

    /**
     * @param Ingredient $ingredient
     */
    public function setIngredient(Ingredient $ingredient): void
    {
        $this->ingredient[] = $ingredient;
    }
}