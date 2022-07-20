<?php

require('../model/userModel.php');
require_once("../controller/panierController.php");


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
    $bddInfo = getUser($bdd, $user['mail']);
    if($bddInfo != false){
      if(password_verify($user['mdp'], $bddInfo['mdp_user'])){
        $_SESSION['user'] = $bddInfo;

        //recuperer le panier !!

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