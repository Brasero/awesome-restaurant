<?php

require_once('../../model/config/Database.php');
require_once('./ingredientController.php');
require_once('./produitController.php');
require_once('../../interface/SQLQueryBuilder.php');
require_once('../../class/MySqlQueryBuilder.php');
require_once('../../class/AbstractEntity.php');
require_once('../../class/AbstractEntityManager.php');
require_once('../../controller/dash/IngredientType.php');
require_once('../../model/dash/IngredientTypeManager.php');

$bdd = Database::getInstance('exemple_panier', 'root', '', 'localhost');

function dispatch(PDO $bdd, string $action, $payload){
    switch($action){
        case 'supprType':
            $manager = new IngredientTypeManager($bdd);
            $manager->create(intval($payload));
            echo $manager->delete();
            break;

        case 'supprCategorie':
            echo deleteCategorie($bdd,$payload);
            break;

        case 'supprIngredient':
            echo deleteIngredient($bdd, $payload);

            break;
    }
}

if(isset($_GET['action'])){
    dispatch($bdd->connection, $_GET['action'], $_GET['payload']);
}
