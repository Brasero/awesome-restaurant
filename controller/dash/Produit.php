<?php
namespace Control\Dash;

use Tool\AbstractEntity;
use Model\Config\Database;
use Model\Dash\CategorieManager;
use Model\Dash\IngredientManager;

class Produit extends AbstractEntity{

    private Produit $produit;

    public function __construct(int $id = null, string $nom = null, string $prix = null, string $img = null, int $ID_taxe = null, int $ID_offre = null, int $ID_categorie = null)
    {

        $this->produit = new Produit($this);
    }

    protected function setId(int $id){
        $this->ID = $id;
        if($id != null){
            $ingrManager = new IngredientManager(Database::$instance->connection);
            $this->setIngredient($ingrManager->getIngredientByProdId($this->ID));
        }
    }

    public function setIngredient(array $data)
    {
        $this->produit->setIngredient($data);
    }

    public function getId()
    {
        return $this->produit->getId();
    }

    public function setNom(string $nom)
    {
        $this->produit->setNom($nom);
    }

    public function getNom()
    {
        return $this->produit->getNom();
    }

    public function setPrix(string $prix)
    {
        $this->produit->setPrix($prix);
    }

    public function getPrix()
    {
        return $this->produit->getPrix();
    }

    
    public function setImg(string $img)
    {
        $this->produit->setImg($img);
    }

    public function getImg()
    {
        return $this->produit->getImg();
    }

    
    public function setId_taxe(int $ID_taxe)
    {
        $this->produit->setId_taxe($ID_taxe);
    }

    public function getId_taxe()
    {
        return $this->produit->getId_taxe();
    }

    
    public function setId_offre($ID_offre)
    {
        $this->produit->setId_offre($ID_offre);
    }

    public function getId_offre()
    {
        return $this->produit->getId_offre();
    }
   
    public function setId_categorie(int $ID_categorie)
    {
        $this->produit->setId_categorie($ID_categorie);
    }

    public function getId_categorie()
    {
        return $this->produit->getId_categorie();
    }

      public function hash(): void
      {
          $this->produit->hash();
      }

}
