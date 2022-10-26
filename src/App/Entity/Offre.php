<?php

namespace App\Entity;

use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OffreRepository")
 * @ORM\Table(name="offre")
 */
class Offre
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private int $id;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $date_debut;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $date_fin;

    /**
     * @ORM\Column(type="float")
     */
    private float $taux;


    /**
     * @ORM\OneToMany(targetEntity="Produit", mappedBy="offre")
     */
    private $produits;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNom(): string
    {
        return html_entity_decode($this->nom);
    }

    /**
     * @param string $nom
     */
    public function setNom(string $nom): void
    {
        $this->nom = htmlentities(strtolower($nom));
    }

    /**
     * @return string
     */
    public function getDateDebut(): string
    {
        return $this->date_debut;
    }

    /**
     * @param string $date_debut
     */
    public function setDateDebut(string $date_debut): void
    {
        $this->date_debut = $date_debut;
    }

    /**
     * @return string
     */
    public function getDateFin(): string
    {
        return $this->date_fin;
    }

    /**
     * @param string $date_fin
     */
    public function setDateFin(string $date_fin): void
    {
        $this->date_fin = $date_fin;
    }

    /**
     * @return int
     */
    public function getTaux(): int
    {
        return floatval($this->taux) * 100;
    }

    /**
     * @param float $taux
     */
    public function setTaux(float $taux): void
    {
        $this->taux = $taux / 100;
    }


    public function getProduits()
    {
        return $this->produits;
    }

    /**
     * @param $produits
     */
    public function setProduits($produits): void
    {
        $this->produits[] = $produits;
    }

    public function getEtat(): string
    {
        $date = new DateTime();
        $date = $date->format('Y-m-d');
        if ($this->date_debut <= $date && $this->date_fin >= $date) {
            return 'actif';
        } else {
            return 'inactif';
        }
    }

    /**
     * Add produit.
     *
     * @param Produit $produit
     *
     * @return Offre
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
    public function removeProduit(Produit $produit)
    {
        return $this->produits->removeElement($produit);
    }
}
