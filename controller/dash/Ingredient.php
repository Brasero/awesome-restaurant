<?php

class Ingredient extends AbstractEntity
{


    public string $nom;
    public string $prix;
    public string $dispo;
    public string $Id_type;




    protected function setId(int $ID)
    {
        $this->ID = $ID;
    }

    public function getId()
    {
        return $this->ID;
    }

    public function setNom(string $nom)
    {
        $this->nom = $nom;
    }

    public function getNom()
    {
        return ucfirst($this->nom);
    }

    public function setPrix(string $prix)
    {
        $this->prix = $prix;
    }

    public function getPrix()
    {
        return $this->prix;
    }

    public function setDispo(string $dispo)
    {
        $this->dispo = $dispo;
    }

    public function getDispo()
    {
        return $this->dispo;
    }

    public function setId_type(string $Id_type)
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
