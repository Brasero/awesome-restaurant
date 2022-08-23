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

function setNewProduct(PDO $bdd, array $data): bool{
    $str = 'INSERT INTO produit (nom_produit, prix_produit, img_produit, ID_taxe, ID_offre, ID_categorie) VALUES (:nom, :prix, :img, :taxe, :offre, :cat)';

    $query = $bdd->prepare($str);

    $query->bindValue(':nom', $data['nom'], PDO::PARAM_STR);
    $query->bindValue(':prix', $data['prix'], PDO::PARAM_STR);
    $query->bindValue(':img', '', PDO::PARAM_STR);
    $query->bindValue(':taxe', 1, PDO::PARAM_INT);
    $query->bindValue(':offre', null, PDO::PARAM_NULL);
    $query->bindValue(':cat', $data['cat'], PDO::PARAM_INT);

    if($query->execute()){
        if($data['ingredients'] != null){
            $str = 'SELECT LAST_INSERT_ID() AS id FROM produit';
            $query = $bdd->query($str);
            $prodId = $query->fetch(PDO::FETCH_ASSOC)['id'];
            $str = 'INSERT INTO ingredient_produit (ID_ingredient_ingredient_produit, ID_produit_ingredient_produit) VALUES (:IdIngredient, :IdProduit)';
            foreach($data['ingredients'] as $ingredient){
                $query = $bdd->prepare($str);

                $query->bindValue(':IdIngredient', $ingredient, PDO::PARAM_INT);
                $query->bindValue(':IdProduit', $prodId, PDO::PARAM_INT);

                $query->execute();
            }

            return true;
        }
    } else {
        return false;
    }
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

function setCategorieNull(PDO $bdd, int $id)
{
    $str = 'DELETE FROM categorie WHERE ID_categorie = :id';

    $query = $bdd->prepare($str);

    $query->bindValue(':id', $id, PDO::PARAM_INT);

    return $query->execute();
}
