<?php

require_once('../model/produitModel.php');
require_once('../model/panierModel.php');


function getPanierByUserId($bdd, $idUser){
  $panier = getPanierOfUserById($bdd, $idUser);

  return $panier;
}

function produitList($bdd){
  return getProduits($bdd);
}

/**
 * Ajoute un produit au panier de l'utilisateur
 *
 * @param PDO $bdd
 * @param int $id
 * @return string
 */
function addItemToPanierById($bdd, $id){
  $produit = getProduitById($bdd, $id);
  
  if(isset($_SESSION['user'])){

    $panier = getPanierByUserId($bdd, $_SESSION['user']['ID_user']);

    if($panier == false){
      //creer un panier
      setNewPanier($bdd, $_SESSION['user']['ID_user']);
      $panier = getPanierByUserId($bdd, $_SESSION['user']['ID_user']);
      setNewProduitToPanier($bdd, $panier['ID_panier'], $produit['ID_produit']);
    } else {
      //ajouter un produit au panier
      setNewProduitToPanier($bdd, $panier['ID_panier'], $produit['ID_produit']);
    }

  } else {
    if(isset($_SESSION['panier'])){
      $exist = false;
      for($i = 0; $i < sizeof($_SESSION['panier']); $i++){
        if($_SESSION['panier'][$i]['ID_produit'] == $produit['ID_produit']){
          $_SESSION['panier'][$i]['qte_panier_ligne'] = $_SESSION['panier'][$i]['qte_panier_ligne'] + 1;
          $exist = true;
          break;
        }
      }

      if($exist == false){
        $produit['qte_panier_ligne'] = 1;
        array_push($_SESSION['panier'], $produit);
      }

    } else {
      $_SESSION['panier'] = [];
      $produit['qte_panier_ligne'] = 1;
      array_push($_SESSION['panier'], $produit);
    }
  }
}

function getPanier($bdd){
  if(isset($_SESSION['user'])){
    $produitList = getPanierContentByUserId($bdd, $_SESSION['user']['ID_user']);

    if($produitList == false){
      return false;
    } else {
      return $produitList;
    }

  } else {
    if(isset($_SESSION['panier'])){
      $produitList = $_SESSION['panier'];
      return $produitList;
    } else {
      return false;
    }
  }
}

