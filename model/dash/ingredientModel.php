<?php

/**
 * Ajoute un nouveau type d'ingrédient en base de données
 *
 * @param PDO $bdd
 * @param string $name nom de l'ingrédient
 * @return boolean  Retourne true si l'insertion à reussie, sinon retourne false
 */
function setNewTypeIngredient(PDO $bdd, string $name) : bool{
    $str = 'INSERT INTO type_ingredient (nom_type_ingredient) VALUES (:nom)';

    $query = $bdd->prepare($str);

    $query->bindValue(':nom', $name, PDO::PARAM_STR);

    return $query->execute();
}

/**
 * Récupère et retourne tout les type d'ingrédient en base de données
 *
 * @param PDO $bdd
 * @return array tableau contenant tout les types d'ingrédients, chaque type aura les index : ID_type_ingredient, nom_type_ingredient
 */
function getTypes(PDO $bdd) : array{
    $str = 'SELECT * FROM type_ingredient';

    $query = $bdd->query($str);

    return $query->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Enregistre en base de données un nouvel ingrédient
 *
 * @param PDO $bdd
 * @param array $data
 * @return boolean retourne true si l'insertion à reussie, sinon retourne false
 */
function setNewIngredient(PDO $bdd, array $data) : bool {
    $str = 'INSERT INTO ingredient (nom_ingredient, prix_ingredient, dispo_ingredient, ID_type_ingredient)
            VALUES (:nom, :prix, :dispo, :idType)';

    $query = $bdd->prepare($str);

    $query->bindValue(':nom', $data['nom'], PDO::PARAM_STR);
    $query->bindValue(':prix', $data['prix'], PDO::PARAM_STR);
    $query->bindValue(':dispo', 1, PDO::PARAM_BOOL);
    $query->bindValue(':idType', $data['type'], PDO::PARAM_INT);

    return $query->execute();
}

/**
 * Retourne la liste de tout les ingrédients en base de données
 *
 * @param PDO $bdd
 * @return array tableau contenant tout les ingrédient en base de données ainsi que leur type d'ingrédient associée.
 * Chaque ingrédient du tableau aura les index : ID_ingredient, nom_ingredient, prix_ingredient, dispo_ingredient, ID_type_ingredient, nom_type_ingredient
 */
function getIngredients(PDO $bdd) : array {
    $str = 'SELECT * FROM ingredient 
            INNER JOIN type_ingredient 
            ON type_ingredient.ID_type_ingredient = ingredient.ID_type_ingredient';

    $query = $bdd->query($str);

    return $query->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Modifie le nom d'un type d'ingrédient en BDD
 *
 * @param PDO $bdd
 * @param array $data tableau de données ayant les index : id, nom
 * @return boolean retourne true si la modification est efféctuée sinon retourne false
 */
function setIngredientTypeName(PDO $bdd, array $data): bool{
    $str = 'UPDATE type_ingredient 
            SET nom_type_ingredient = :nom 
            WHERE ID_type_ingredient = :id';

    $query = $bdd->prepare($str);

    $query->bindValue(':nom', $data['nom'], PDO::PARAM_STR);
    $query->bindValue(':id', $data['id'], PDO::PARAM_INT);
    return $query->execute();
}

?>