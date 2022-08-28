<?php
/**
 * Créer une connexion à la base de données l'objet PDO est enregistré dans $connection
 * Class Singleton
 */
class Database{


  private $host;
  private $dbname;
  private $user;
  private $mdp;
  private $char;
  public $connection;
  public static $instance;

  private function __construct($dbname, $user, $mdp, $host, $char){

    $this->host = $host;
    $this->dbname = $dbname;
    $this->user = $user;
    $this->mdp = $mdp;
    $this->char = $char;
    $this->connect();
  }


  private function connect(){
    try{
      $this->connection = new PDO("mysql:host={$this->host};dbname={$this->dbname};charset={$this->char}", $this->user, $this->mdp);
    } catch(PDOException $e){
      echo 'Error '. $e->getMessage();
      die();
    }
  }

  public static function getInstance($dbname, $user, $mdp, $host, $char = 'utf8'){
    if(self::$instance == null){
      self::$instance = new Database($dbname, $user, $mdp, $host, $char);
    }

    return self::$instance;
  }


}

?>