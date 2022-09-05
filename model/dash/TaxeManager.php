<?php

namespace Model\Dash;

use PDO;
use Control\Dash\Taxe;
use Tool\AbstractEntityManager;


class TaxeManager extends AbstractEntityManager{

    const TABLE_NAME = 'taxe';

    public Taxe $taxe;

    protected function reset(): TaxeManager
    {
        $this->taxe = new Taxe();

        return $this;
    }

    public function getById(int $id): Taxe
    {
        $this->reset();

        $str = $this->queryBuilder
                        ->select(self::TABLE_NAME, ['*'])
                        ->where('ID_taxe', ':id')
                        ->getSQL();
                       

        $query = $this->db->prepare($str);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();

        $array = $query->fetch(PDO::FETCH_ASSOC);

        $this->taxe->hydrate($array, self::TABLE_NAME);

        return $this->taxe;
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
            $i = new Taxe();
            $i->hydrate($prod, self::TABLE_NAME);
            array_push($array, $i);
        }

        return $array;
    }

}