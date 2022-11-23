<?php

namespace App\Entity;

use App\Entity\PanierLigne;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="panier")
 */
class Panier
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id_panier")
     * @ORM\GeneratedValue
     * @var int
     */
    private int $id;

    /**
     * @ORM\OneToMany(targetEntity="PanierLigne", mappedBy="panier")
     */
    private $panier_ligne;

    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="panier")
     */
    private int $user;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUser(): int
    {
        return $this->user;
    }

    /**
     * @param int $user
     */
    public function setUser(int $user): void
    {
        $this->user = $user;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->panier_ligne = new ArrayCollection();
    }

    /**
     * Add panierLigne.
     *
     * @param PanierLigne $panierLigne
     *
     * @return Panier
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
     * @return ArrayCollection
     */
    public function getPanierLigne(): ArrayCollection
    {
        return $this->panier_ligne;
    }
}
