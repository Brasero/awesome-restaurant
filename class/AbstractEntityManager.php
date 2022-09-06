<?php
namespace Tool;

use PDO;
use Inter\SQLQueryBuilder;
use Tool\MySqlQueryBuilder;

abstract class AbstractEntityManager
{
    protected PDO $db;
    protected SQLQueryBuilder $queryBuilder;


    public function __construct(PDO $bdd)
    {
        $this->db = $bdd;
        $this->queryBuilder = new MySqlQueryBuilder();
    }

    abstract protected function reset(): self;

    abstract protected function getById(int $id): AbstractEntity;

    abstract public function getAll(): array;

    abstract public function createNew(array $array): string;


    /**
     * Vérifie qu'un nom d'élément soit unique dans sa table
     *
     * @param string $name  Nom de l'élément a ajouté en bdd
     * @return boolean  Retourne true si le nom n'existe pas en bdd, sinon false 
     */
    protected function isUnique(string $name): bool
    {
        $data = $this->getAll();

        foreach($data as $obj){
            if($obj->getNom() == $name)
            {
                return false;
            }
        }

        return true;
    }


}
