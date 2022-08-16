<?php
require_once("../../model/dash/ingredientModel.php");


/**
 * Ajoute un nouveau type d'ingrédient en base dedonnées.
 *
 * @param PDO $bdd
 * @param string $name
 * @return string
 */
function addTypeIngredient(PDO $bdd, string $name){
    $name = htmlentities(strip_tags($name));
    $name = strtolower($name);

    $types = getTypes($bdd);

    //On crée une closure (fonction anonyme enregistrer dans un variable) qui permettra de verifier si le nom du produit exist dans la bdd
    $exist = function($types, $name){
        foreach($types as $type){
            if(in_array($name, $type)){
                return true;
            }
        }
        return false;
    };

    //on appel cette closure dans une condition pour empêcher les doublons en base de données.
    if($exist($types, $name)){
        return '<span class="error">Ce type existe déjà</span>';
    }
    else {
        //Si le type n'existe pas en base on l'enregistre.
        if(setNewTypeIngredient($bdd, $name)){
            return '<span class="success">Votre type d\'ingrédient "'.$name.'" à été ajouté.</span>';
        }else{
            return '<span class="error">Une erreur s\'est produite.</span>';
        }
    }
}

/**
 * Récupère tout les types d'ingrédients
 *
 * @param PDO $bdd
 * @return array
 */
function getAllType(PDO $bdd){
    $types = getTypes($bdd);

    $traitedTypes = [];

    //Boucle pour traiter le tableau reçu de la base de donnée et le transformer en un tableau plus facilement manipulable
    foreach($types as $type){
        $t = [];
        $t['nom'] = ucfirst($type['nom_type_ingredient']);
        $t['id'] = $type['ID_type_ingredient'];

        array_push($traitedTypes, $t);
    }

    return $traitedTypes;
}

?>