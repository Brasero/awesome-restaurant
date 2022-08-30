<?php

class CategorieManager extends AbstractEntityManager{

    const TABLE_NAME = 'categorie';


    protected function reset(): self
    {
        $this->categorie = new Categorie();

        return $this;
    }

    public function getById(int $id): Categorie
    {
        $cat = new Categorie();

        $str = 'SELECT * FROM categorie WHERE ID_categorie = :id';

        $query = $this->db->prepare($str);

        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();

        $array = $query->fetch(PDO::FETCH_ASSOC);

        $cat->hydrate($array, self::TABLE_NAME);

        return $cat;
    }

    public function getAll(): array
    {
        $returnArray = [];

        $str = 'SELECT * FROM '.self::TABLE_NAME.'';

        $query = $this->db->query($str);

        $data = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach($data as $categorie)
        {
            $object = new Categorie();
            $object->hydrate($data, self::TABLE_NAME);
            array_push($returnArray, $object);
        }

        return $returnArray;
    }

}


?>