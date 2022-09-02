<?php

class Ingredient extends AbstractEntity
{


    public ?string $nom;
    public ?string $prix;
    public ?string $dispo;
    public ?int $Id_type;




    protected function setID(int $ID)
    {
        $this->ID = intval($ID);
    }

    public function getID()
    {
        return $this->ID;
    }

    public function setNom(?string $nom)
    {
        $this->nom = $nom;
    }

    public function getNom()
    {
        return ucfirst(html_entity_decode($this->nom));
    }

    public function setPrix(?string $prix)
    {
        $this->prix = $prix;
    }

    public function getPrix()
    {
        return $this->prix;
    }

    public function setDispo(?bool $dispo)
    {
        $this->dispo = $dispo;
    }

    public function getDispo()
    {
        return $this->dispo;
    }

    public function setId_type(?int $Id_type)
    {
        $this->Id_type = $Id_type;
    }

    public function getId_type()
    {
        return $this->Id_type;
    }

    public function hash(): void
    {
        $prix = str_replace(',', '.', $this->prix);
        $nom = strtolower(htmlentities(strip_tags($this->nom)));
        $this->setNom($nom);
        $this->setPrix($prix);
    }
}


?>
