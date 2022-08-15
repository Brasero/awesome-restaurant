<?php

require_once('../../model/dash/adminConnexionModel.php');

function connectAdmin(PDO $bdd, array $array){
    $admin['mail'] = strip_tags($array['mail']);
    $admin['mdp'] = $array['mdp'];

    $bdd = getUserByEmail($bdd, $admin['mail']);

    if(password_verify($admin['mdp'], $bdd['mdp_user']) && $bdd['ID_role'] == 2){
        $_SESSION['admin'] = $bdd;
        unset($_SESSION['mdp_user']);
        $_SESSION['admin']['credentials'] = true;
        header('location: index.php');
    }else{
        header('location: ../index.php');
    }
}

?>