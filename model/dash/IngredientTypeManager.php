<?php

namespace Model\Dash;

use App\Framework\Toaster\Toast;
use Control\Dash\IngredientType;
use PDO;
use Tool\AbstractEntityManager;


class IngredientTypeManager extends AbstractEntityManager
{

    const TABLE_NAME = 'type_ingredient';

    public IngredientType $type;

    protected function reset(): self
    {
        $this->type = new IngredientType();

        return $this;
    }

    public function create(int $ID = null, string $nom = null): IngredientType
    {
        $this->reset();
        $this->type->hydrate(['nom' => $nom, 'ID' => $ID], self::TABLE_NAME);
        return $this->type;
    }

    public function getById(int $id): IngredientType
    {
        $this->reset();

        $str = $this->queryBuilder
                        ->select(self::TABLE_NAME, ['*'])
                        ->where('ID_'.self::TABLE_NAME, ':id')
                        ->getSQL();

        $query = $this->db->prepare($str);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $this->type->hydrate($data, self::TABLE_NAME);
        
        return $this->type;
    }

    public function getAll(): array
    {
        $array = [];
        $str = $this->queryBuilder
                        ->select(self::TABLE_NAME, ['*'])
                        ->order('nom_'.self::TABLE_NAME)
                        ->getSQL();
        $query = $this->db->query($str);
        $data = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach($data as $type)
        {
            $obj = new IngredientType();
            $obj->hydrate($type, self::TABLE_NAME);
            array_push($array, $obj);
        }

        return $array;
    }

    public function createNew(array $data): string
    {
        $toast = new Toast();
        $this->reset();
        $this->type->hydrate($data, self::TABLE_NAME);
        if($this->isUnique($this->type->getNom())){
            $this->type->hash();
            $str = $this->queryBuilder
                        ->insert(self::TABLE_NAME, ['nom_'.self::TABLE_NAME])
                        ->values([[':nom']])
                        ->getSQL();
            $query = $this->db->prepare($str);
            $query->bindValue(':nom', $this->type->getNomBrut(), PDO::PARAM_STR);
            
            if($query->execute()){
                $toast->createToast("Type d'ingredient \"{$this->type->getNom()}\" à été ajouté", Toast::SUCCESS);
            }
            else {
                $toast->createToast("Une erreur est survenue.", Toast::ERROR);
            }
        }
        else{
            $toast->createToast('Ce type existe déjà.', Toast::ERROR);
        }



        return $toast->renderToast();
    }

    public function update(array $data): string
    {
        $toast = new Toast();
        $this->reset();
        $data['nom'] = $data['ingredientTypeNomUpdate'];
        $this->type->hydrate($data, self::TABLE_NAME);
        $str = $this->queryBuilder
                        ->update(self::TABLE_NAME)
                        ->set(['nom_'.self::TABLE_NAME => ':nom'])
                        ->where('ID_'.self::TABLE_NAME, ':id')
                        ->getSQL();
        $query = $this->db->prepare($str);
        $query->bindValue(':nom', $this->type->getNomBrut(), PDO::PARAM_STR);
        $query->bindValue(':id', $this->type->getID(), PDO::PARAM_INT);
        
        if($query->execute()){
            $toast->createToast('Type modifié.', Toast::SUCCESS);
        }
        else{
            $toast->createToast('Une erreur s\'est produite.', Toast::ERROR);
        }

        return $toast->renderToast();
    }

    public function delete(): bool 
    {

        $str = $this->queryBuilder
                        ->delete(self::TABLE_NAME)
                        ->where('ID_'.self::TABLE_NAME, ':id')
                        ->getSQL();
        $query = $this->db->prepare($str);
        $query->bindValue(':id', $this->type->getID(), PDO::PARAM_INT);
        if($query->execute()){
            return true;
        }
        
        return false;        
    }   

}
