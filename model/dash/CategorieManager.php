<?php

class CategorieManager extends AbstractEntityManager
{

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

        $str = 'SELECT * FROM ' . self::TABLE_NAME . '';

        $query = $this->db->query($str);

        $data = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data as $categorie) {
            $object = new Categorie();
            $object->hydrate($categorie, self::TABLE_NAME);
            array_push($returnArray, $object);
        }

        return $returnArray;
    }

    public function createNew(array $data): string
    {
        $toast = new Toast();
        $this->reset();
        $this->categorie->hydrate($data, self::TABLE_NAME);

        if ($this->isUnique($this->categorie->getNom())) {
            $this->categorie->hash();
            $str = $this->queryBuilder
                ->insert(self::TABLE_NAME, ['nom_' . self::TABLE_NAME, 'img_' . self::TABLE_NAME])
                ->values([[':nom', ':img']])
                ->getSQL();

            $query = $this->db->prepare($str);
            $query->bindValue(':nom', $this->categorie->getNom(), PDO::PARAM_STR);
            $query->bindValue(':img', null, PDO::PARAM_STR);
            if ($query->execute()) {

                $toast->createToast("categorie \"{$this->categorie->getNom()}\" à été ajouté", Toast::SUCCESS);
            } else {
                var_dump($query->errorInfo());
                $toast->createToast('Une erreur est survenue.', Toast::ERROR);
            }
        } else $toast->createToast("Cette categorie existe déja.", Toast::ERROR);

        return $toast->renderToast();
    }
}
