<?php

class ProduitManager extends AbstractEntityManager{

    const TABLE_NAME = 'produit';

    public Produit $prod;

    protected function reset(): ProduitManager
    {
        $this->prod = new Produit();

        return $this;
    }

    public function getById(int $id): Produit
    {
        $this->reset();

        $str = $this->queryBuilder
                        ->select(self::TABLE_NAME, ['*'])
                        ->where('ID_produit', ':id')
                        ->getSQL();
                       

        $query = $this->db->prepare($str);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();

        $array = $query->fetch(PDO::FETCH_ASSOC);

        $this->prod->hydrate($array, self::TABLE_NAME);

        return $this->prod;
    }

    public function getAll(): array
    {
        $array = array();

        $str = $this->queryBuilder
                        ->select(self::TABLE_NAME, ['*'])
                        ->getSQL();

        $query = $this->db->query($str);
        $data = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach($data as $prod){
            $i = new Produit();
            $i->hydrate($prod, self::TABLE_NAME);
            array_push($array, $i);
        }

        return $array;
    }

}

?>