<?php


class IngredientManager extends AbstractEntityManager{


    const TABLE_NAME = 'ingredient';

    public Ingredient $ingredient;

    protected function reset(): self
    {
        $this->ingredient = new Ingredient();
        return $this;
    }

    public function getIngredientByProdId(int $prodId){
        $returnArray = [];
        $str = $this->queryBuilder
                        ->select(self::TABLE_NAME, ['*'])
                        ->where('ID_produit_ingredient_produit', ':id')
                        ->getSQL();

        $query = $this->db->prepare($str);

        $query->bindValue(':id', $prodId, PDO::PARAM_INT);
        $query->execute();

        $array = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach($array as $rel){
            array_push($returnArray, $this->getById($rel['ID_ingredient_ingredient_produit']));
        }

        return $returnArray;
    }

    public function getAll(): array
    {
        $returnArray = [];

        $str = $this->queryBuilder
                        ->select(self::TABLE_NAME, ['*'])
                        ->getSQL();

        $query = $this->db->query($str);

        $data = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach($data as $ingredient){
            $object = new Ingredient();
            $object->hydrate($ingredient, self::TABLE_NAME);
            array_push($returnArray, $object);
        }

        return $returnArray;
    }

    protected function getById(int $id): Ingredient
    {

        $ingredient = new Ingredient();

        $str = "SELECT * FROM ingredient WHERE ID_ingredient = :id";
        $query = $this->db->prepare($str);

        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();

        $array = $query->fetch(PDO::FETCH_ASSOC);

        $ingredient->hydrate($array, self::TABLE_NAME);

        return $ingredient;

    }

}

?>