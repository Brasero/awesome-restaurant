<?php
require_once("../../model/dash/ingredientModel.php");


/**
 * Ajoute un nouveau type d'ingrédient en base dedonnées.
 *
 * @param PDO $bdd
 * @param string $name
 * @return string retourne un chaine de caractére contenant un element HTML à afficher
 */
function addTypeIngredient(PDO $bdd, string $name) : string{
    $name = htmlentities(strip_tags($name));
    $name = strtolower($name);

    $types = getTypes($bdd);

    //On crée une closure (fonction anonyme enregistrer dans un variable) qui permettra de verifier si le nom du type de produit existe dans la bdd
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
        return '<span class="error">
                    <span class="message">
                        Ce type existe déjà
                    </span>
                    <span class="progressBar"></span>
                </span>';
    }
    else {
        //Si le type n'existe pas en base on l'enregistre.
        if(setNewTypeIngredient($bdd, $name)){
            return '<span class="success">
                        <span class="message">
                            Votre type d\'ingrédient "'.$name.'" à été ajouté.
                        </span>
                        <span class="progressBar"></span>
                    </span>';
        }else{
            return '<span class="error">
                        <span class="message">
                            Une erreur s\'est produite.
                        </span>
                        <span class="progressBar"></span>
                    </span>';
        }
    }
}

/**
 * Récupère tout les types d'ingrédients
 *
 * @param PDO $bdd
 * @return array retourne un tableau contenant tous les type d'ingrédient, chaque type aura les index : nom, id
 */
function getAllType(PDO $bdd) : array{
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


/**
 * Ajoute un ingrédient en base de données si ce dérnier n'existe pas et que le format est valable
 *
 * @param PDO $bdd
 * @param array $data Ensemble des données de l'ingredient, venant de la variable $_POST ou tout autre variable contenant les info de l'ingrédient
 * @return string retourne un chaine de caractére contenant un element HTML à afficher
 */
function addNewIngredient(PDO $bdd, array $data) : string {
    //création d'un tableau vide pour y stockées les données traitées
    $ing = [];
    //traitement et assignation des données
    $ing['nom'] = strtolower(htmlentities(strip_tags($data['ingredientNom'])));
    $ing['prix'] = htmlentities(strip_tags(str_replace(',', '.', $data['ingredientPrix'])));
    $ing['type'] = $data['ingredientType'];
    
    //On crée une closure (fonction anonyme enregistrer dans un variable) qui permettra de verifier si le nom du produit existe dans la bdd
    $exist = function ($name, $array){
        foreach($array as $data){
            if(in_array($name, $data)){
                return true;
            }
        }

        return false;
    };

    //On verifie que les champs ont bien été rempli comme attendu
    if(!empty($ing['nom']) && !empty($ing['prix']) && !empty($ing['type']) && $ing['type'] != "false"){
        //on récupère la liste de tout les ingrédients déjà existant
        $ingredientArray = getIngredients($bdd);

        //On compare les ingredient existant avec l'ingredient que l'on cherche à ajouter en bdd, si il existe déjà on renvoie une erreur
        if(!$exist($ing['nom'], $ingredientArray)){
            
            //On tente d'enregistrer l'ingredient en base de données, si ce dernier ne s'enregistre pas on renvoie un erreur, sinon on renvoi un message de succées
            if(setNewIngredient($bdd, $ing)){
                return "<span class='success'>
                            <span class='message'>
                                Ingrédient ajouté
                            </span>
                            <span class='progressBar'></span>
                        </span>";
            } else {
                return "<span class='error'>
                            <span class='message'>
                                Une erreur s'est produite, réessayez.
                            </span>
                            <span class='progressBar'></span>
                        </span>";
            }

        } else {
            return "<span class='error'>
                        <span class='message'>
                            L'ingrédient existe déjà.
                        </span>
                        <span class='progressBar'></span>
                    </span>";
        }

    } else {
        return "<span class='error'>
                    <span class='message'>
                        Tout les champs requis n'ont pas été remplis.
                    </span>
                    <span class='progressBar'></span>
                </span>";
    }
}

?>