<?php


class IngtredientTypeManger extends AbstractEntityManager
{

    const TABLE_NAME = 'ingredient_type';

    public IngredientType $type;

    protected function reset(): self
    {
        $this->type = new IngredientType();

        return $this;
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

}