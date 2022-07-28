<?php

require('../model/userModel.php');
require_once("../controller/panierController.php");


function assignPanierToUser(PDO $bdd){
  if(isset($_SESSION['panier'])){
    foreach($_SESSION['panier'] as $item){
      addItemToPanierById($bdd, $item['ID_produit'], $item['qte_panier_ligne']);
    }
    unset($_SESSION['panier']);
  }
}

/**
 * Connection de l'utilisateur retourne un element HTML
 *
 * @param PDO $bdd
 * @param array $array
 * @return string
 */
function connectUser($bdd, $array){
  if(isset($array['mail'], $_POST['mdp'])){
    $user['mail'] = strip_tags($array['mail']);
    $user['mdp'] = $array['mdp'];
    $bddInfo = '';//Définir les informations de l'utilisateur
    if($bddInfo != false){
      if(password_verify($user['mdp'], $bddInfo['mdp_user'])){
        $_SESSION['user'] = $bddInfo;

        assignPanierToUser($bdd);

        unset($_SESSION['user']['mdp_user']);
        unset($_SESSION['panier']);
        header('Location: index.php');
      } else {
        return '<span class="errorMessage">Mauvais mot de passe</span>';
      }
    }else{
      return '<span class="errorMessage">Adresse mail inconnue</span>';
    }
  }
}

?>