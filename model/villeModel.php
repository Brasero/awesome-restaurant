<?php

function getVillesByNameLike(PDO $bdd, string $name){
    $str = 'SELECT nom_ville, codePostal_ville FROM ville WHERE nom_ville LIKE :nom';
    
    $query = $bdd->prepare($str);

    $query->bindValue(':nom', $name.'%', PDO::PARAM_STR);

    $query->execute();

    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function getVillesByCp(PDO $bdd, int $cp){
    $str = 'SELECT nom_ville, codePostal_ville FROM ville WHERE codePostal_ville LIKE :cp';
    
    $query = $bdd->prepare($str);

    $query->bindValue(':cp', $cp.'%', PDO::PARAM_STR);

    $query->execute();

    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function getVilleByNameAndCp(PDO $bdd, array $ville){
    $str = 'SELECT ID_ville FROM ville WHERE nom_ville = :nom AND codePostal_ville = :cp';

    $query = $bdd->prepare($str);
    $query->bindValue(':nom', $ville['nom'], PDO::PARAM_STR);
    $query->bindValue(':cp', $ville['cp'], PDO::PARAM_STR);
    $query->execute();

    return $query->fetch(PDO::FETCH_ASSOC);
}

?>