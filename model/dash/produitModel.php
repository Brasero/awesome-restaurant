<?php

/**
 * Ajoute une nouvelle catégorie en base de données
 *
 * @param PDO $bdd
 * @param string $name nom de la categorie
 * @return boolean Retourne true si l'insertion à reussie, sinon retourne false
 */
function setNewCategorie(PDO $bdd, string $name): bool
{
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
function getCategorie(PDO $bdd): array
{
    $str = 'SELECT * FROM categorie';

    $query = $bdd->query($str);

    return $query->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Modifie le nom d'un type d'ingrédient en bdd
 *
 * @param PDO $bdd
 * @param array $data tableau de données ayant les index : id, nom
 * @return boolean retourne true si la modification est efféctuée sinon retourne false
 */
function setCategorieName(PDO $bdd, array $data): bool
{
    $str = 'UPDATE categorie
            SET nom_categorie = :nom
            WHERE ID_categorie = :id';

    $query = $bdd->prepare($str);

    $query->bindValue(':nom', $data['nom'], PDO::PARAM_STR);
    $query->bindValue(':id', $data['id'], PDO::PARAM_INT);
    return $query->execute();
}
