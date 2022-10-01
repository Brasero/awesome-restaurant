<?php
namespace App\Produit\Entity;

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
     * @Column(type="integer", name="ID_produit")
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
     * @Column(type="string", name="nom_offre")
     */
    private string $nom;

    /**
     * @Column(type="integer")
     */
    private int $ID_categorie;

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

    public function setId_categorie(int $ID_categorie): void
    {
        $this->ID_categorie = $ID_categorie;
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

    public function getId_categorie()
    {
        return $this->ID_categorie;
    }

    public function getId_taxe()
    {
        return $this->ID_taxe;
    }
}