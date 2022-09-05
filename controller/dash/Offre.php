<?php
namespace Control\Dash;

use Tool\AbstractEntity;

class Offre extends AbstractEntity {

    public string $nom;
    public float $taux;
    public string $date_debut;
    public string $date_fin;


    protected function setID(?int $ID = null): void 
    {
        $this->ID = $ID;
    }

    public function getID(): int 
    {
        return $this->ID;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function setTaux(string $taux): self
    {
        $this->taux = floatval($taux);

        return $this;
    }

    public function getTaux(): float
    {
        return $this->taux;
    }

    public function getTauxLitteral(): string
    {
        return str_replace('.', ',', ($this->taux * 100)).'%';
    }

    public function getNom(): string
    {
        return ucfirst(html_entity_decode($this->nom));
    }

    public function setDate_debut(string $date): self 
    {
        $this->date_debut = htmlentities(strip_tags($date));

        return $this;
    }

    public function getDate_debut(): string
    {
        return html_entity_decode($this->date_debut);
    }
    
    public function getDate_debutShort(): string
    {
        return html_entity_decode(substr($this->date_debut, 2));
    }

    public function setDate_fin(string $date): self
    {
        $this->date_fin = htmlentities(strip_tags($date));

        return $this;
    }


    public function getDate_fin(): string 
    {
        return html_entity_decode($this->date_fin);
    }

    public function getDate_finShort(): string 
    {
        return html_entity_decode(substr($this->date_fin, 2));
    }

    public function getEtat(): string
    {
        $date = date('Y-m-d');

        switch($date)
        {
            case ($date < $this->getDate_debut()):
                $return = '
                    <span class="waiting">
                        A venir 
                    </span>';
                break;

            case ($date <= $this->getDate_fin() && $date >= $this->getDate_debut()): 
                $return = '
                    <span class="enableOffer">
                        En cour
                    </span>';
                break;
            
                case ($date > $this->getDate_fin()): 
                    $return = '
                        <span class="ended">
                            Términée
                        </span>';
                    break;

                default:
                    $return = '
                        <span class="ended">
                            Error
                        </span>
                    ';
        }

        return $return;
    }

    public function hash(): void
    {
        $this->nom = strtolower(htmlentities(strip_tags($this->nom)));
        $this->taux = $this->taux / 100;
    }
}