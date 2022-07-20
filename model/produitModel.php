<?php

/**
 * Récupère et retourne tout les produits en base de données
 *
 * @param PDO $bdd
 * @return array
 */
function getProduits($bdd){
  $str = 'SELECT * FROM produit';
  $query = $bdd->query($str);
  if($query->rowCount() > 0){
    return $query->fetchAll(PDO::FETCH_ASSOC);
  }
  return false;
}

/**
 * Récupere et renvoi un produit par rapport à son ID
 *
 * @param PDO $bdd
 * @param int $id
 * @return array
 */
function getProduitById($bdd, $id){
  $str = 'SELECT * FROM produit WHERE ID_produit = :id';
  $query = $bdd->prepare($str);
  $query->bindValue(':id', $id, PDO::PARAM_INT);
  $query->execute();

  return $query->fetch();
}


