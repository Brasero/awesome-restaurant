<?php


class IngredientManager extends AbstractEntityManager
{


    const TABLE_NAME = 'ingredient';

    public Ingredient $ingredient;

    protected function reset(): self
    {
        $this->ingredient = new Ingredient();
        return $this;
    }

    public function create(string $ID = null, int $nom = null, int $prix = null, bool $dispo = null, int $Id_type = null): Ingredient
    {
        $this->reset();
        $this->ingredient->hydrate(['nom' => $nom, 'ID' => $ID, 'prix' => $prix, 'dispo' => $dispo, 'ID_type' => $Id_type], self::TABLE_NAME);
        return $this->ingredient;
    }

    public function getIngredientByProdId(int $prodId)
    {
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

    public function createNew(array $data): string
    {
        $toast = new Toast();
        $this->reset();
        $this->ingredient->hydrate($data, self::TABLE_NAME);

        if ($this->isUnique($this->ingredient->getNom())) {
            $this->ingredient->hash();
            $str = $this->queryBuilder
                ->insert(self::TABLE_NAME, ['nom_' . self::TABLE_NAME, 'prix_' . self::TABLE_NAME, 'ID_type_' . self::TABLE_NAME, 'dispo_' . self::TABLE_NAME])
                ->values([[':nom', ':prix', ':Id_type', ':dispo']])
                ->getSQL();

            $query = $this->db->prepare($str);
            $query->bindValue(':nom', $this->ingredient->getNom(), PDO::PARAM_STR);
            $query->bindValue(':prix', $this->ingredient->getPrix(), PDO::PARAM_STR);
            $query->bindValue(':Id_type', $this->ingredient->getId_type(), PDO::PARAM_INT);
            $query->bindValue(':dispo', 1, PDO::PARAM_BOOL);
            if ($query->execute()) {

                $toast->createToast("ingredient \"{$this->ingredient->getNom()}\" à été ajouté", Toast::SUCCESS);
            } else {
                var_dump($query->errorInfo());
                $toast->createToast('Une erreur est survenue.', Toast::ERROR);
            }
        } else $toast->createToast("Cette ingredient existe déja.", Toast::ERROR);

        return $toast->renderToast();
    }

    public function update(array $data): string
    {
        $toast = new Toast();
        $this->reset();
        $data['nom'] = $data['ingredientNomUpdate'];
        $data['prix'] = $data['ingredientPrixUpdate'];
        $data['ID_type'] = $data['ingredientType'];
        $data['ID'] = $data['ingredientIdUpdate'];
        if (isset($data['ingredientDispoUpdate'])) {
            $data['dispo'] = 1;
        } else {
            $data['dispo'] = 0;
        }


        $this->ingredient->hydrate($data, self::TABLE_NAME);
        $str = $this->queryBuilder
            ->update(self::TABLE_NAME)
            ->set(['nom_' . self::TABLE_NAME => ':nom', 'prix_' . self::TABLE_NAME => ':prix', 'dispo_' . self::TABLE_NAME => ':dispo', 'ID_type_' . self::TABLE_NAME => ':ID_type'])
            ->where('ID_' . self::TABLE_NAME, ':id')
            ->getSQL();
        $query = $this->db->prepare($str);
        $query->bindValue(':nom', $this->ingredient->getNom(), PDO::PARAM_STR);
        $query->bindValue(':prix', $this->ingredient->getPrix(), PDO::PARAM_STR);
        $query->bindValue(':dispo', $this->ingredient->getDispo(), PDO::PARAM_BOOL);
        $query->bindValue(':ID_type', $this->ingredient->getId_type(), PDO::PARAM_INT);
        $query->bindValue(':id', $this->ingredient->getID(), PDO::PARAM_INT);

        if ($query->execute()) {
            $toast->createToast('Ingredient modifié.', Toast::SUCCESS);
        } else {
            $toast->createToast('Une erreur s\'est produite.', Toast::ERROR);
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
        $query->bindValue(':id', $this->ingredient->getID(), PDO::PARAM_INT);
        if ($query->execute()) {
            return true;
        }

        return false;
    }
}

?>
