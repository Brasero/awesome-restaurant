<?php

namespace Tool;

abstract class AbstractEntity
{

    protected int $ID;

    public function hydrate(array $data, string $tableName): void
    {
        foreach($data as $key => $value){
            $method = 'set'.ucfirst(strtolower(str_replace('_'.$tableName, '', $key)));
            if(method_exists($this, $method)){
                $this->$method($value);
            }
        }
    }

    public function getNomBrut(): string
    {
        return $this->produit->nom;
    }

    abstract public function hash(): void;

    /**
     * @return int
     */
    public function getID(): int
    {
        return $this->ID;
    }
}

