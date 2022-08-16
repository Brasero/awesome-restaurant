<?php

function setNewTypeIngredient(PDO $bdd, string $name){
    $str = 'INSERT INTO type_ingredient (nom_type_ingredient) VALUES (:nom)';

    $query = $bdd->prepare($str);

    $query->bindValue(':nom', $name, PDO::PARAM_STR);

    return $query->execute();
}

function getTypes(PDO $bdd){
    $str = 'SELECT * FROM type_ingredient';

    $query = $bdd->query($str);

    return $query->fetchAll(PDO::FETCH_ASSOC);
}

?>