<?php


class Taxe extends AbstractEntity{

    private float $taxe;

    private function setID(int $id): void
    {
        $this->ID = $id;
    }

    public function getID(): int
    {
        return $this->ID;
    }

    private function setTaux(string $float): void
    {
        $taux = floatval($float);
        $this->taxe = $taux;
    }

    public function setTaxeLitterale(string $taxe): void
    {
        $taux = intval($taxe);
        $taux = $taux / 100;
        $this->taxe = $taux;
    }

    public function getTaxeTolitteral(): string
    {
        $txt = $this->taxe." %";

        return $txt;
    }

    public function getTaxePourcent(): float
    {
        return $this->taxe;
    }

}