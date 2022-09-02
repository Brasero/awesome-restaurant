<?php

class Categorie extends AbstractEntity
{


    public ?string $nom;
    public ?string $img;

    public function __construct(int $id = null, string $name = null, string $img = null)
    {
    }

    protected function setID(int $id)
    {
        $this->ID = intval($id);
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

    public function setImg($img)
    {
        $this->img = $img;
    }

    public function getImg()
    {
        return $this->img;
    }

    public function hash(): void
    {
        $nom = strtolower(htmlentities(strip_tags($this->nom)));
        $this->setNom($nom);
    }
}
