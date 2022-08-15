<?php

class AdresseModel{

    private $ID_adresse;
    private string $nom_adresse;
    private string $prefix_adresse;
    private string $n_adresse;
    private int $ID_ville;


    public function __construct(int $ID_adresse = null, string $nom_adresse, string $prefix, string $numero, int $IDville){

        $this->setID_adresse($ID_adresse);
        $this->setNom_adresse($nom_adresse);
        $this->setPrefix_adresse($prefix);
        $this->setN_adresse($numero);
        $this->setID_ville($IDville);

    }



    public function getID_adresse(){
        return $this->ID_adresse;
    }

    public function getNom_adresse(){
        return $this->nom_adresse;
    }

    public function getPrefix_adresse(){
        return $this->prefix_adresse;
    }

    public function getN_adresse(){
        return $this->n_adresse;
    }

    public function getID_ville(){
        return $this->ID_ville;
    }

    public function setID_adresse($id){
        $this->ID_adresse = $id;
    }

    public function setNom_adresse($nom){
        $this->nom_adresse = $nom;
    }

    public function setPrefix_adresse($prefix){
        $this->prefix_adresse = $prefix;
    }

    public function setN_adresse($n){
        $this->n_adresse = $n;  
    }

    public function setID_ville($id){
        $this->ID_ville = $id;
    }

    public function saveAdresse(PDO $bdd){
        $str = 'INSERT INTO adresse (nom_adresse, prefixe_adresse, n_adresse, ID_ville) VALUES (:nom, :prefixe, :n_adresse, :IDville)';

        $strId = 'SELECT LAST_INSERT_ID() AS ID FROM adresse';

        $query = $bdd->prepare($str);

        $query->bindValue(':nom', $this->nom_adresse, PDO::PARAM_STR);
        $query->bindValue(':prefixe', $this->prefix_adresse, PDO::PARAM_STR);
        $query->bindValue(':n_adresse', $this->n_adresse, PDO::PARAM_STR);
        $query->bindValue(':IDville', $this->ID_ville, PDO::PARAM_INT);
        $query->execute();

        $query = $bdd->prepare($strId);
        $query->execute();

        $this->setID_adresse($query->fetch(PDO::FETCH_ASSOC)['ID']);
    }

}


?>