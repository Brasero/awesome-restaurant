<?php

class IngredientType extends AbstractEntity
{
    public string $nom;

    public function getNom(): string
    {
        return ucfirst($this->nom);
    }

    public function setNom(string $nom): void
    {
        $nom = htmlentities(strip_tags($nom));
        $nom = strtolower($nom);
        $this->nom = $nom;
    }

    protected function setID(int $ID): void
    {
        $this->ID = intval($ID);
    }

    public function getID(): int
    {
        return $this->ID;
    }
}