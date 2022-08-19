<?php
require_once('../../model/dash/produitModel.php');


/**
 * Ajoute une nouvelle catégorie en base de données 
 *
 * @param PDO $bdd
 * @param string $name
 * @return string retourne une chaine de caractère contenant un élément HTML à afficher
 */
function addCategorie(PDO $bdd, string $name): string
{
    $name = htmlentities(strip_tags($name));
    $name = strtolower($name);

    $categories = getCategorie($bdd);

    // On crée une closure (fonction anonyme enregister dans une variable) qui permettra de verifier si le nom de la catégorie du produit existe dans la bdd
    $exist = function ($categories, $name) {
        foreach ($categories as $categorie) {
            if (in_array($name, $categorie)) {
                return true;
            }
        }
        return false;
    };

    // on appel cette closure dans une contition pour empêcher les doublons en base de données.
    if ($exist($categories, $name)) {
        return '<span class="error">
                    <span class="message">
                        Cette catégorie existe déjà
                    </span>
                    <span class="progressBar"></span>
                </span>';
    } else {
        // Si la catégorie n'existe pas en base on l'enregistre.
        if (setNewCategorie($bdd, $name)) {
            return '<span class="success">
                        <span class="message">
                            Votre catégorie "' . $name . '" à été ajouté.
                        </span>
                        <span class="progressBar"></span>
                    </span>';
        } else {
            return '<span class="error">
                        <span class"message">
                            Une erreur s\'est produite.
                        </span>
                        <span class="progressBar"></span>           
                    </span>';
        }
    }
}

/**
 * Récupère toutes les catégories
 *
 * @param PDO $bdd
 * @return array retourne un tableau contenant toute les catégories, chaque catégorie aura les index : nom, id 
 */
function getAllCategorie(PDO $bdd): array
{
    $categories = getCategorie($bdd);

    $traitedCategories = [];

    // Boucle pour traiter le tableau reçu de la base de données et le transformer en un tableau plus facilement manipulable
    foreach ($categories as $categorie) {
        $t = [];
        $t['nom'] = ucfirst($categorie['nom_categorie']);
        $t['id'] = $categorie['ID_categorie'];

        array_push($traitedCategories, $t);
    }

    return $traitedCategories;
}


/**
 * Traite la modification du nom de la catégorie, verifie au préalable que le nom n'existe pas déjà en base de donnée
 *
 * @param PDO $bdd
 * @param array $data
 * @return string retourne un élément HTML à afficher
 */
function updateCategorieName(PDO $bdd, array $data): string
{
    $categorie = [];
    $categorie['nom'] = strtolower(htmlentities(strip_tags($data['categorieNomUpdate'])));
    $categorie['id'] = intval(strip_tags($data['categorieIdUpdate']));

    $categories = getCategorie($bdd);

    $exist = function ($categories, $name) {
        foreach ($categories as $categorie) {
            if (in_array($name, $categorie)) {
                return true;
            }
        }
        return false;
    };
    if (!$exist($categories, $categorie['nom'])) {
        if (setCategorieName($bdd, $categorie)) {
            return "<span class='success'>
                        <span class='message'>
                            Modification enregistrée.
                        </span>
                        <span class='progressBar'></span>
                    </span>";
        } else {
            return "<span class='error'>
                        <span class='message'>
                            Une erreur s'est produite,réessayez.
                        </span>
                        <span class='progressBar'></span>
                    </span>";
        }
    } else {
        return "<span class='error'>
                    <span class='message'>
                        Cette catégorie existe déjà.
                    </span>
                    <span class='progressBar'></span>
                </span>";
    }
}

function deleteCategorie(PDO $bdd, int $id)
{
    return setCategorieNull($bdd, intval($id));
}
