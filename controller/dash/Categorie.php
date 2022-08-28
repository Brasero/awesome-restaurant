<?php

class Categorie{

    private int $ID;
    public string $nom;
    public ?string $img;

    public function __construct(int $id = null, string $name = null, string $img = null){

    }

    
    public function hydrate(array $data){
        foreach($data as $key => $value){
            $method = 'set'.ucfirst(strtolower(str_replace('_categorie', '', $key)));
            if(method_exists(Produit::class, $method)){
                $this->$method($value);
            }
        }
    }



    private function setId(int $id){
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