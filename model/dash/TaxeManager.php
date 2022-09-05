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

        protected function taxeIsUnique(string $taux): bool
    {
        $data = $this->getAll();

        foreach($data as $obj){
            if($obj->getTaxePourcent() == $taux)
            {
                return false;
            }
        }

        return true;
    }

    public function create(int $ID = null, string $taxe = null): Taxe
    {
        $this->reset();
        $this->taxe->hydrate(['ID' => $ID, 'taxe' => $taxe], self::TABLE_NAME);
        return $this->taxe;
    }

 public function createNew(array $data): string
    {
        $toast = new Toast();
        $this->reset();
        $this->taxe->hydrate($data, self::TABLE_NAME);
        $this->taxe->hash();
        if($this->taxeIsUnique($this->taxe->getTaxePourcent()))
        { 
            $str = $this->queryBuilder
                        ->insert(self::TABLE_NAME, ['taux_'.self::TABLE_NAME])
                        ->values([[':taux']])
                        ->getSQL();
            $query = $this->db->prepare($str);
            $query->bindValue(':taux', $this->taxe->getTaxePourcent(), PDO::PARAM_STR);
            
            if($query->execute()){
                $toast->createToast("taxe \"{$this->taxe->getTaxeTolitteral()}\" à été ajouté", Toast::SUCCESS);
            }
            else {
                $toast->createToast("Une erreur est survenue.", Toast::ERROR);
            }
         }else
            {
                $toast->createToast("Cette taxe existe déja.", Toast::ERROR);
            }
        return $toast->renderToast();
    }

        public function delete(): bool
    {

        $str = $this->queryBuilder
            ->delete(self::TABLE_NAME)
            ->where('ID_' . self::TABLE_NAME, ':id')
            ->getSQL();
        $query = $this->db->prepare($str);
        $query->bindValue(':id', $this->taxe->getID(), PDO::PARAM_INT);
        if ($query->execute()) {
            return true;
        }

        return false;
    }

      public function update(array $data): string
    {
        $toast = new Toast();
        $this->reset();
        $data['ID'] = $data['taxeIdUpdate'];
        $data['taux'] = $data['taxeTauxUpdate'];


        $this->taxe->hydrate($data, self::TABLE_NAME);
        $str = $this->queryBuilder
            ->update(self::TABLE_NAME)
            ->set(['taux_' . self::TABLE_NAME => ':taux'])
            ->where('ID_' . self::TABLE_NAME, ':id')
            ->getSQL();
        $query = $this->db->prepare($str);
        $query->bindValue(':taux', $this->taxe->getTaxePourcent(), PDO::PARAM_STR);
        $query->bindValue(':id', $this->taxe->getID(), PDO::PARAM_INT);

        if ($query->execute()) {
            $toast->createToast('Taxe modifié.', Toast::SUCCESS);
        } else {
            $toast->createToast('Une erreur s\'est produite.', Toast::ERROR);
        }

        return $toast->renderToast();
    }

}