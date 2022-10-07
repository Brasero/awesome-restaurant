<?php

namespace Model\Dash;

use App\Framework\Toaster\Toast;
use Control\Dash\Offre;
use PDO;
use Tool\AbstractEntityManager;

class OffreManager extends AbstractEntityManager
{

    const TABLE_NAME = 'offre';

    private Offre $offre;



    protected function reset(): self
    {
        $this->offre = new Offre();

        return $this;
    }

    public function createNew(array $array): string
    {
        $toast = new Toast();
        $this->reset();
        $this->offre->hydrate($array, $this::TABLE_NAME);
        if($this->isViable()) {
            $this->offre->hash();
            $str = $this->queryBuilder
                            ->insert($this::TABLE_NAME, [
                                'nom_'.self::TABLE_NAME, 
                                'taux_'.self::TABLE_NAME, 
                                'date_debut_'.self::TABLE_NAME, 
                                'date_fin_'.self::TABLE_NAME
                            ])
                            ->values([[
                                ':nom',
                                ':taux',
                                ':debut',
                                ':fin'
                            ]])
                            ->getSQL();

            $query = $this->db->prepare($str);
            $query->bindValue(':nom', $this->offre->getNomBrut(), \PDO::PARAM_STR);
            $query->bindValue(':taux', $this->offre->getTaux(), \PDO::PARAM_STR);
            $query->bindValue(':debut', $this->offre->getDate_debut(), \PDO::PARAM_STR);
            $query->bindValue(':fin', $this->offre->getDate_fin(), \PDO::PARAM_STR);
            if($query->execute()){
                $toast->createToast('Votre offre à été enregistrée.', Toast::SUCCESS);
            } else {
                $toast->createToast('Une erreur s\'est produite lors de l\'enregistrement.', Toast::ERROR);
            }
        }
        else {
            $toast->createToast('La date de début d\'offre doit être antérieure à la date de fin.', Toast::ERROR);
        }
        
        return $toast->renderToast();
    }


    private function isViable(): bool 
    {
        if($this->offre->date_debut <= $this->offre->date_fin){
            return true;
        }

        return false;
    }

    public function getById(int $id): Offre
    {
        $this->reset();

        $str = $this->queryBuilder
                        ->select($this::TABLE_NAME, ['*'])
                        ->where('ID_'.$this::TABLE_NAME, ':id')
                        ->getSQL();
        $query = $this->db->prepare($str); 
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $this->offre->hydrate($data, $this::TABLE_NAME);

        return $this->offre;
    }

    public function getAll(): array
    {
        $this->reset();
        $array = array();

        $str = $this->queryBuilder
                        ->select($this::TABLE_NAME, ['*'])
                        ->getSQL();

        $query = $this->db->query($str);
        $offres = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach($offres as $offre)
        {
            $this->reset();
            $this->offre->hydrate($offre
        , $this::TABLE_NAME);
            $array[] = $this->offre;
        }

        return $array;
    }

    public function update(array $data): string
    {
        $toast = new Toast();
        $this->reset();
        $data['ID'] = $data['ID_offre_update'];
        $data['nom'] = $data['nom_offre_update'];
        $data['taux'] = $data['taux_offre_update'];
        $data['date_debut'] = $data['date_debut_offre_update'];
        $data['date_fin'] = $data['date_fin_offre_update'];
        $this->offre->hydrate($data, self::TABLE_NAME);
        if($this->isViable()) {
            $this->offre->hash();
            $str = $this->queryBuilder
                            ->update(self::TABLE_NAME)
                            ->set([
                                    'nom_'.self::TABLE_NAME => ':nom', 
                                    'taux_'.$this::TABLE_NAME => ':taux', 
                                    'date_debut_'.$this::TABLE_NAME => ':debut', 
                                    'date_fin_'.$this::TABLE_NAME => ':fin'
                                ])
                            ->where('ID_'.self::TABLE_NAME, ':id')
                            ->getSQL();
            $query = $this->db->prepare($str);
            $query->bindValue(':nom', $this->offre->getNomBrut(), PDO::PARAM_STR);
            $query->bindValue(':taux', $this->offre->getTaux(), PDO::PARAM_STR);
            $query->bindValue(':debut', $this->offre->getDate_debut(), PDO::PARAM_STR);
            $query->bindValue(':fin', $this->offre->getDate_fin(), PDO::PARAM_STR);
            $query->bindValue(':id', $this->offre->getID(), PDO::PARAM_INT);
            
            if($query->execute()){
                $toast->createToast('Offre modifiée.', Toast::SUCCESS);
            }
            else{
                $toast->createToast('Une erreur s\'est produite.', Toast::ERROR);
            }
        }
        else {
            $toast->createToast('La date de début d\'offre doit être antérieure à la date de fin.', Toast::ERROR);
        }

        return $toast->renderToast();
    }

}