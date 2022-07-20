<?php
require_once('../model/produitModel.php');

function getPanierOfUserById($bdd, $id){
  $str = 'SELECT * FROM panier WHERE ID_user_panier = :id';

  $query = $bdd->prepare($str);
  $query->bindValue(':id', $id, PDO::PARAM_INT);

  if($query->execute()){

    $panier = $query->fetch(PDO::FETCH_ASSOC);
    return $panier;

  } else {

    return false;
    
  }
}

function getPanierContentByUserId($bdd, $id){
  $str = 'SELECT *
          FROM panier 
          INNER JOIN panier_ligne ON panier.ID_panier = panier_ligne.ID_panier_panier_ligne 
          INNER JOIN produit ON produit.ID_produit = panier_ligne.ID_produit_panier_ligne 
          WHERE panier.ID_user_panier = :id ';

  $query = $bdd->prepare($str);
  $query->bindValue(':id', $id, PDO::PARAM_INT);
  $query->execute();
  $result = $query->fetchAll();
  return $result;
}

/**
 * Créer un nouveau panier pour un utilisateur dont on a passé l'ID
 *
 * @param PDO $bdd
 * @param int $idUser
 * @return void
 */
function setNewPanier($bdd, $idUser){
  $str = 'INSERT INTO panier (total_panier, ID_user_panier) VALUES (:total, :id)';

  $query = $bdd->prepare($str);
  $query->bindValue(':total', 0, PDO::PARAM_STR);
  $query->bindValue(':id', $idUser, PDO::PARAM_INT);

  $query->execute();
}

function checkIfProductInPanierExist($bdd, $idProd, $idPanier){
  $str = 'SELECT * FROM panier_ligne WHERE ID_panier_panier_ligne = :idPanier AND ID_produit_panier_ligne = :idProd';

  $query = $bdd->prepare($str);
  $query->bindValue(':idPanier', $idPanier, PDO::PARAM_INT);
  $query->bindValue(':idProd', $idProd, PDO::PARAM_INT);

  $query->execute();

  return $query->fetch(PDO::FETCH_ASSOC);
}

function setNewProduitToPanier($bdd, $idPanier, $idProduit){

  $existPanier = checkIfProductInPanierExist($bdd, $idProduit, $idPanier);

  if($existPanier != false){

    $str = 'UPDATE panier_ligne SET qte_panier_ligne = qte_panier_ligne + 1 WHERE ID_panier_ligne = :id';

    $query = $bdd->prepare($str);
    $query->bindValue(':id', $existPanier['ID_panier_ligne'], PDO::PARAM_INT);
    $query->execute();

  } else {
    $str = 'INSERT INTO panier_ligne(ID_panier_panier_ligne, ID_produit_panier_ligne, qte_panier_ligne) VALUES (:idPanier, :idProd, :qte)';

    $query = $bdd->prepare($str);
    $query->bindValue(':idPanier', $idPanier, PDO::PARAM_INT);
    $query->bindValue(':idProd', $idProduit, PDO::PARAM_INT);
    $query->bindValue(':qte', 1, PDO::PARAM_INT);
  
    $query->execute();
  }

  $produit = getProduitById($bdd, $idProduit);
  
  $str = 'UPDATE panier SET total_panier = total_panier + :prix WHERE ID_panier = :id';

  $query = $bdd->prepare($str);
  $query->bindValue(':prix', $produit['prix_produit'], PDO::PARAM_STR);
  $query->bindValue(':id', $idPanier, PDO::PARAM_INT);

  $query->execute();
 
}