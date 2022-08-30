<?php


abstract class AbstractEntityManager
{
    protected PDO $db;

    public function __construct(PDO $bdd){
        $this->db = $bdd;
    }

    abstract protected function reset(): self;

    abstract protected function getById(int $id): AbstractEntity;

    abstract public function getAll(): array;

}