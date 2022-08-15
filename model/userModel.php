<?php

function setUser(PDO $bdd, array $user){
    $str = 'INSERT INTO user (nom_user, mail_user, mdp_user, prenom_user, tel_user, ID_role, ID_adresse) VALUES (:nom_user, :mail_user, :mdp_user, :prenom_user, :tel_user, :ID_role, :ID_adresse)';

    $query = $bdd->prepare($str);
    $query->bindValue(':nom_user', $user['nom'], PDO::PARAM_STR);
    $query->bindValue(':mail_user', $user['mail'], PDO::PARAM_STR);
    $query->bindValue(':mdp_user', $user['mdp'], PDO::PARAM_STR);
    $query->bindValue(':prenom_user', $user['prenom'], PDO::PARAM_STR);
    $query->bindValue(':tel_user', $user['tel'], PDO::PARAM_STR);
    $query->bindValue(':ID_role', $user['role'], PDO::PARAM_INT);
    $query->bindValue(':ID_adresse', $user['adresse'], PDO::PARAM_INT);
    return $query->execute();
}

function getUserByEmail(PDO $bdd, string $mail){
    $str = 'SELECT * FROM user WHERE mail_user = :mail';

    $query = $bdd->prepare($str);

    $query->bindValue(':mail', $mail, PDO::PARAM_STR);
    $query->execute();

    return $query->fetch(PDO::FETCH_ASSOC);
}

?>