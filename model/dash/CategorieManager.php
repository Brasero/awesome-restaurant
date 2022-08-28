<?php

class CategorieManager{

    public PDO $connection;

    public function __construct(PDO $bdd){
        $this->connection = $bdd;
    }

    public function getCategorieById(int $id){
        $cat = new Categorie();

        $str = 'SELECT * FROM categorie WHERE ID_categorie = :id';

        $query = $this->connection->prepare($str);

        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();

        $array = $query->fetch(PDO::FETCH_ASSOC);

        $cat->hydrate($array);

        return $cat;
    }

}


?>