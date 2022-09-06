<?php

namespace Model\Dash;

use PDO;
use Tool\Toast;
use Control\Dash\Produit;
use Tool\AbstractEntityManager;

class ProduitManager extends AbstractEntityManager
{

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

        foreach ($data as $prod) {
            $i = new Produit();
            $i->hydrate($prod, self::TABLE_NAME);
            array_push($array, $i);
        }

        return $array;
    }

    public function createNew(array $data): string
    {
        $toast = new Toast();
        $this->reset();
        $this->prod->hydrate($data, self::TABLE_NAME);

        if ($this->isUnique($this->produit->getNom())) {
            $this->prod->hash();
            $str = $this->queryBuilder
                ->insert(self::TABLE_NAME, ['nom_' . self::TABLE_NAME, 'prix_' . self::TABLE_NAME, 'img_' . self::TABLE_NAME, 'ID_taxe', 'ID_offre', 'ID_produit'])
                ->values([[':nom', ':prix', ':img', ':ID_taxe', 'ID_offre', 'ID_produit']])
                ->getSQL();

            $query = $this->db->prepare($str);
            $query->bindValue(':nom', $this->prod->getNom(), PDO::PARAM_STR);
            $query->bindValue(':img', null, PDO::PARAM_STR);
            if ($query->execute()) {

                $toast->createToast("produit \"{$this->prod->getNom()}\" à été ajouté", Toast::SUCCESS);
            } else {
                var_dump($query->errorInfo());
                $toast->createToast('Une erreur est survenue.', Toast::ERROR);
            }
        } else $toast->createToast("Cette produit existe déja.", Toast::ERROR);

        return $toast->renderToast();
    }
}
