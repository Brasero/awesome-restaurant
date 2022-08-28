<?php


class IngredientManager{

    public PDO $connection;

    public function __construct(PDO $bdd)
    {
        $this->connection = $bdd;
    }

    public function getIngredientByProdId(int $prodId){
        $returnArray = [];
        $str = 'SELECT * FROM ingredient_produit WHERE ID_produit_ingredient_produit = :id';

        $query = $this->connection->prepare($str);

        $query->bindValue(':id', $prodId, PDO::PARAM_INT);
        $query->execute();

        $array = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach($array as $rel){
            array_push($returnArray, $this->getIngredientById($rel['ID_ingredient_ingredient_produit']));
        }

        return $returnArray;
    }

    private function getIngredientById(int $id){

        $ingredient = new Ingredient();

        $str = "SELECT * FROM ingredient WHERE ID_ingredient = :id";
        $query = $this->connection->prepare($str);

        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();

        $array = $query->fetch(PDO::FETCH_ASSOC);

        $ingredient->hydrate($array);

        return $ingredient;

    }

}

?>