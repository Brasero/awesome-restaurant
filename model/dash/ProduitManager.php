<?php

class ProduitManager{

    private PDO $connection;

    public function __construct(PDO $bdd)
    {
        $this->connection = $bdd;
    }

    public function getProduitById(int $id){
        $prod = new Produit();

        $str = 'SELECT * FROM produit WHERE ID_produit = :id';

        $query = $this->connection->prepare($str);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();

        $array = $query->fetch(PDO::FETCH_ASSOC);

        $prod->hydrate($array);

        return $prod;
    }

    public function getProduits(){
        $array = array();

        $str = 'SELECT * FROM produit';

        $query = $this->connection->query($str);
        $data = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach($data as $prod){
            $i = new Produit();
            $i->hydrate($prod);
            array_push($array, $i);
        }

        return $array;
    }

}

?>