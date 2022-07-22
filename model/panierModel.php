<?php
require_once('../model/produitModel.php');


/**
 * Récupere le panier d'un utilisateur en base de données
 *
 * @param PDO $bdd
 * @param int $id
 * @return array|bool
 */
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

/**
 * Récupere et retourne toute les info d'un panier (produit y compris) en fonction de l'id de l'utilisateur
 *
 * @param PDO $bdd
 * @param int $id
 * @return array
 */
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

/**
 * Recuperer puis renvois une ligne d'enregistrement de la table panier_ligne si le produit existe dans le panier du client , renvoir false sinon
 *
 * @param PDO $bdd
 * @param int $idProd Identifiant du produit recherché
 * @param int $idPanier Identifiant du panier client 
 * @return void
 */
function checkIfProductInPanierExist($bdd, $idProd, $idPanier){
  $str = 'SELECT * FROM panier_ligne WHERE ID_panier_panier_ligne = :idPanier AND ID_produit_panier_ligne = :idProd';

  $query = $bdd->prepare($str);
  $query->bindValue(':idPanier', $idPanier, PDO::PARAM_INT);
  $query->bindValue(':idProd', $idProd, PDO::PARAM_INT);

  $query->execute();

  return $query->fetch(PDO::FETCH_ASSOC);
}

/**
 * Insére un nouveau produit dans le panier du client, si le produit y est déjà présent, incrémente seulement sa quantité
 *
 * @param PDO $bdd
 * @param int $idPanier Identifiant du panier client 
 * @param int $idProduit Identifiant du produit à ajouté
 * @param int $qte Quantité à ajouté au panier
 * @return bool
 */
function setNewProduitToPanier($bdd, $idPanier, $idProduit, $qte){

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
    $query->bindValue(':qte', $qte, PDO::PARAM_INT);
  
    $query->execute();
  }

  $produit = getProduitById($bdd, $idProduit);
  
  $str = 'UPDATE panier SET total_panier = total_panier + :prix WHERE ID_panier = :id';

  $query = $bdd->prepare($str);
  $query->bindValue(':prix', $produit['prix_produit'] * $qte, PDO::PARAM_STR);
  $query->bindValue(':id', $idPanier, PDO::PARAM_INT);

  $query->execute();
 
}

/**
 * Augmente la quantité d'un produit dans un panier
 *
 * @param PDO $bdd
 * @param integer $idPanier
 * @param integer $idProd
 * @return boolean
 */
function setQteProdMore(PDO $bdd, int $idPanier, int $idProd): bool{
  $str = 'UPDATE panier_ligne SET qte_panier_ligne = qte_panier_ligne + 1 WHERE ID_panier_panier_ligne = :idPanier AND ID_produit_panier_ligne = :idProd';

  $query = $bdd->prepare($str);

  $query->bindValue(':idPanier', $idPanier, PDO::PARAM_INT);
  $query->bindValue(':idProd', $idProd, PDO::PARAM_INT);

  if($query->execute()){
    $prod = getProduitById($bdd, $idProd);
    $str = 'UPDATE panier SET total_panier  = total_panier + :prix WHERE ID_panier = :id';

    $query = $bdd->prepare($str);

    $query->bindValue(':prix', $prod['prix_produit'], PDO::PARAM_STR);
    $query->bindValue(':id', $idPanier, PDO::PARAM_INT);

    return $query->execute();
  }

  return false;
}

/**
 * Retourn la quantité d'un produit dans le panier 
 *
 * @param PDO $bdd
 * @param integer $idProd Identifiant du produit recherché
 * @param integer $idPanier Identifiant du panier client
 * @return bool
 */
function getQteOfProd(PDO $bdd, int $idProd, int $idPanier){
  $str = 'SELECT qte_panier_ligne FROM panier_ligne WHERE ID_produit_panier_ligne = :idProd AND ID_panier_panier_ligne = :idPanier';

  $query = $bdd->prepare($str);

  $query->bindValue(':idProd', $idProd, PDO::PARAM_INT);
  $query->bindValue(':idPanier', $idPanier, PDO::PARAM_INT);

  $query->execute();

  $response = $query->fetch(PDO::FETCH_ASSOC);

  return $response;
}


/**
 * Décrémente la quantité d'un produit dans un panier, si il n'y en avais qu'un, supprime le produit du panier client 
 *
 * @param PDO $bdd
 * @param integer $idProd Identifiant du produit 
 * @param integer $idPanier Identifiant du panier client
 * @param string $action Action a efectuer (decrease OR suppr)
 * @return bool
 */
function setQteProdLess(PDO $bdd, int $idProd, int $idPanier, string $action){

  $endRequest = ' WHERE ID_produit_panier_ligne = :idProd AND ID_panier_panier_ligne = :idPanier';

  $produit = getProduitById($bdd, $idProd);

  if($action == 'decrease'){
    $str = 'UPDATE panier_ligne SET qte_panier_ligne = qte_panier_ligne -1';
  } elseif($action == 'suppr'){
    $str = 'DELETE FROM panier_ligne';
  }

  $str .= $endRequest;

  $query = $bdd->prepare($str);

  $query->bindValue(':idProd', $idProd, PDO::PARAM_INT);
  $query->bindValue(':idPanier', $idPanier, PDO::PARAM_INT);

  if($query->execute()){

    $panier = getPanierOfUserById($bdd, $_SESSION['user']['ID_user']);

    if($action == 'suppr'){
      if($produit['prix_produit'] == $panier['total_panier']){
        $str = 'DELETE FROM panier WHERE ID_panier = :id';
        $query = $bdd->prepare($str);

        $query->bindValue(':id', $idPanier, PDO::PARAM_INT);

        return $query->execute();
      }
    } 

    $str = 'UPDATE panier SET total_panier = total_panier - :prix WHERE ID_panier = :id';

    $query = $bdd->prepare($str);

    $query->bindValue(':id', $idPanier, PDO::PARAM_INT);
    $query->bindValue(':prix', $produit['prix_produit'], PDO::PARAM_STR);

    return $query->execute();
  }
}