<?php

/**
 * Ajoute une nouvelle catégorie en base de données
 *
 * @param PDO $bdd
 * @param string $name nom de la categorie
 * @return boolean Retourne true si l'insertion à reussie, sinon retourne false
 */
function setNewCategorie(PDO $bdd, string $name) : bool{
    $str = 'INSERT INTO categorie (nom_categorie) VALUES (:nom)';

    $query = $bdd->prepare($str);

    $query->bindValue(':nom', $name, PDO::PARAM_STR);

    return $query->execute();
}

/**
 * Récupère et retourne toute les catégorie en base de données
 *
 * @param PDO $bdd
 * @return array tableau contenant toute les catégorie, chaque catégorie aura les index : ID_categorie, nom_categorie
 */
function getCategorie(PDO $bdd) : array{
    $str = 'SELECT * FROM categorie';

    $query = $bdd->query($str);

    return $query->fetchAll(PDO::FETCH_ASSOC);
}
