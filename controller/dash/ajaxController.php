<?php

require_once('../../model/config/Database.php');
require_once('./ingredientController.php');

$bdd = new Database('exemple_panier', 'root', '', 'localhost');

function dispatch(PDO $bdd, string $action, $payload){
    switch($action){
        case 'supprType':
            echo deleteTypeIngredient($bdd, $payload);
            break;
    }
}

if(isset($_GET['action'])){
    dispatch($bdd->connection, $_GET['action'], $_GET['payload']);
}

?>