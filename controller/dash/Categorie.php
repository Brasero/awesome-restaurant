<?php

class Categorie extends AbstractEntity{

    
    public string $nom;
    public ?string $img;

    public function __construct(int $id = null, string $name = null, string $img = null){

    }

    protected function setId(int $id){
        $this->ID = $id;
    }

    public function getId(){
        return $this->ID;
    }

    public function setNom(string $nom){
        $this->nom = $nom;
    }

    public function getNom(){
        return $this->nom;
    }

    public function setImg($img){
        $this->img = $img;
    }

    public function getImg(){
        return $this->img;
    }

}

?>