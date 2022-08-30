<?php

class Ingredient extends AbstractEntity{

    private int $ID;
    public string $nom;

    public function __construct(){

    }

    protected function setId(int $ID){
        $this->ID = $ID;
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


}

?>