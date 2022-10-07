<?php

namespace Model\Dash;

use App\Framework\Toaster\Toast;
use Control\Dash\Categorie;
use PDO;
use Tool\AbstractEntityManager;
use Tool\ImageUploader;


class CategorieManager extends AbstractEntityManager
{

    const TABLE_NAME = 'categorie';

    private ImageUploader $uplaoder;


    protected function reset(): self
    {
        $this->categorie = new Categorie();

        return $this;
    }

    public function create(int $ID = null, string $nom = null, string $img = null): Categorie
    {
        $this->reset();
        $this->categorie->hydrate(['ID' => $ID, 'nom' => $nom, 'img' => $img,], self::TABLE_NAME);
        return $this->categorie;
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
            $this->uplaoder = new ImageUploader($_FILES, '../assets/img/ressources/categorie/');
            if($this->uplaoder->isSuccess()){
                $this->categorie->setImg($this->uplaoder->getName());
                $this->categorie->hash();
                $str = $this->queryBuilder
                    ->insert(self::TABLE_NAME, ['nom_' . self::TABLE_NAME, 'img_' . self::TABLE_NAME])
                    ->values([[':nom', ':img']])
                    ->getSQL();

                $query = $this->db->prepare($str);
                $query->bindValue(':nom', $this->categorie->getNom(), PDO::PARAM_STR);
                $query->bindValue(':img', $this->categorie->getImg(), PDO::PARAM_STR);
                if ($query->execute()) {

                    $toast->createToast("Categorie \"{$this->categorie->getNom()}\" à été ajouté", Toast::SUCCESS);
                } else {
                    var_dump($query->errorInfo());
                    $toast->createToast('Une erreur est survenue.', Toast::ERROR);
                }    
            } else {
                $toast->createToast('L\'image est trop volumineuse.', Toast::ERROR);
            }

        } else $toast->createToast("Cette categorie existe déja.", Toast::ERROR);

        return $toast->renderToast();
    }

    public function delete(): bool
    {

        $str = $this->queryBuilder
            ->delete(self::TABLE_NAME)
            ->where('ID_' . self::TABLE_NAME, ':id')
            ->getSQL();
        $query = $this->db->prepare($str);
        $query->bindValue(':id', $this->categorie->getID(), PDO::PARAM_INT);
        if ($query->execute()) {
            return true;
        }

        return false;
    }

    public function update(array $data): string
    {
        $toast = new Toast();
        $this->reset();
        $data['ID'] = $data['categorieIdUpdate'];
        $data['nom'] = $data['categorieNomUpdate'];


        $this->categorie->hydrate($data, self::TABLE_NAME);
        $str = $this->queryBuilder
            ->update(self::TABLE_NAME)
            ->set(['nom_' . self::TABLE_NAME => ':nom', 'img_' . self::TABLE_NAME => ':img'])
            ->where('ID_' . self::TABLE_NAME, ':id')
            ->getSQL();
        $query = $this->db->prepare($str);
        $query->bindValue(':nom', $this->categorie->getNom(), PDO::PARAM_STR);
        $query->bindValue(':img', null, PDO::PARAM_STR);
        $query->bindValue(':id', $this->categorie->getID(), PDO::PARAM_INT);

        if ($query->execute()) {
            $toast->createToast('categorie modifié.', Toast::SUCCESS);
        } else {
            $toast->createToast('Une erreur s\'est produite.', Toast::ERROR);
        }

        return $toast->renderToast();
    }
}
