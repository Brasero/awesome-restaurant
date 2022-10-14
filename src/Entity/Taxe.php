<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="taxe")
 */
class Taxe
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue
     * @var int
     */
    private int $id;

    /**
     * @ORM\Column(type="float", name="taux_taxe")
     * @var float
     */
    private float $taux;

    /**
     * @ORM\OneToMany(targetEntity="Produit", mappedBy="taxe")
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
     * @return float
     */
    public function getTaux(): float
    {
        return $this->taux;
    }

    /**
     * @param float $taux
     */
    public function setTaux($taux): void
    {
        $taux = str_replace(',', '.', $taux);
        $this->taux = floatval($taux);
    }
}
