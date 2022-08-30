<?php

class IngredientType extends AbstractEntity
{
    public ?string $nom;

    public function __construct(?string $nom = null)
    {
        $this->setNom($nom);
    }

    public function getNom(): string
    {
        return ucfirst(html_entity_decode($this->nom));
    }

    public function getNomBrut(): string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): void
    {
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

    public function hash(): void
    {
        $nom = strtolower(htmlentities(strip_tags($this->nom)));

        $this->setNom($nom);
    }
}