<?php

class Ingredient{

    private int $ID;
    public string $nom;

    public function __construct(){

    }
    
    
    public function hydrate(array $data){
        foreach($data as $key => $value){
            $method = 'set'.ucfirst(strtolower(str_replace('_ingredient', '', $key)));
            if(method_exists(Ingredient::class, $method)){
                $this->$method($value);
            }
        }
    }

    private function setId(int $ID){
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