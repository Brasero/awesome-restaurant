<?php


class Taxe extends AbstractEntity{

    protected float $taxe;

    protected function setID(int $id): void
    {
        $this->ID = $id;
    }

    public function getID(): int
    {
        return $this->ID;
    }

    protected function setTaux(string $float): void
    {
        $taux = floatval($float);
        $this->taxe = $taux;
    }

    public function setTaxeLitterale(string $taxe): void
    {
        $taux = floatval($taxe);
        $taux = $taux / 100;
        $this->taxe = $taux;
    }

    public function getTaxeTolitteral(): string
    {
        $txt = ($this->taxe* 100) ." %";

        return $txt;
    }

    public function getTaxePourcent(): float
    {
        return $this->taxe;
    }
   public function hash(): void
    {
        
       $taxe = str_replace(',','.',$this->taxe);
       $this->taxe = $taxe; 
       
    }

}