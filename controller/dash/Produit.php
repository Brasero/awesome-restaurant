<?php
namespace Control\Dash;

use Tool\AbstractEntity;
use Model\Config\Database;
use Model\Dash\CategorieManager;
use Model\Dash\IngredientManager;

class Produit extends AbstractEntity{

    public string $nom;
    public string $prix;
    public string $img;
    public int $ID_taxe;
    public ?int $ID_offre;
    public Categorie $ID_categorie;
    public array $ingredients = [];

    public function __construct(int $id = null, string $nom = null, string $prix = null, string $img = null, int $ID_taxe = null, int $ID_offre = null, int $ID_categorie = null)
    {
        
    }

    protected function setId(int $id){
        $this->ID = $id;
        if($id != null){
            $ingrManager = new IngredientManager(Database::$instance->connection);
            $this->setIngredient($ingrManager->getIngredientByProdId($this->ID));
        }
    }

    public function setIngredient(array $data){
        $this->ingredients = $data;
    }

    public function getId(){
        return $this->ID;
    }

    public function setNom(string $nom){
        $this->nom = strtolower($nom);
    }

    public function getNom(){
        return ucfirst($this->nom);
    }

    public function setPrix(string $prix){
        $this->prix = $prix;
    }

    public function getPrix(){
        return $this->prix;
    }

    
    public function setImg(string $img){
        $this->img = $img;
    }

    public function getImg(){
        return $this->img;
    }

    
    public function setId_taxe(int $ID_taxe){
        $this->ID_taxe = $ID_taxe;
    }

    public function getId_taxe(){
        return $this->ID_taxe;
    }

    
    public function setId_offre($ID_offre){
        $this->ID_offre = $ID_offre;
    }

    public function getId_offre(){
        return $this->ID_offre;
    }
   
    public function setId_categorie(int $ID_categorie){
        $manager = new CategorieManager(Database::$instance->connection);
        $this->ID_categorie = $manager->getById($ID_categorie);
    }

    public function getId_categorie(){
        return $this->ID_categorie;
    }

      public function hash(): void
        {
            $nom = strtolower(htmlentities(strip_tags($this->nom)));
            $this->setNom($nom);
        }

}
