<?php


function getUserByEmail(PDO $bdd, string $mail){
    $str = 'SELECT * FROM user WHERE mail_user = :mail';

    $query = $bdd->prepare($str);

    $query->bindValue(':mail', $mail, PDO::PARAM_STR);
    $query->execute();

    return $query->fetch(PDO::FETCH_ASSOC);
}

?>