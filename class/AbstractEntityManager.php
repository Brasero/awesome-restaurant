<?php


abstract class AbstractEntityManager
{
    protected PDO $db;
    protected SQLQueryBuilder $queryBuilder;

    public function __construct(PDO $bdd){
        $this->db = $bdd;
        $this->queryBuilder = new MySqlQueryBuilder();
    }

    abstract protected function reset(): self;

    abstract protected function getById(int $id): AbstractEntity;

    abstract public function getAll(): array;

}