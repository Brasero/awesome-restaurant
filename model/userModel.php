<?php

function setNewUser($bdd, $user){
  $str = 'INSERT INTO user (nom_user, mail_user, mdp_user) VALUES (:nom, :mail, :mdp)';
  $query = $bdd->prepare($str);
  $query->bindValue(':nom', $user['nom'], PDO::PARAM_STR);
  $query->bindValue(':mail', $user['mail'], PDO::PARAM_STR);
  $query->bindValue(':mdp', $user['mdp'], PDO::PARAM_STR);
  $query->execute();
}

function getUser($bdd, $mail){
  $str = 'SELECT * FROM user WHERE mail_user = :mail';
  $query = $bdd->prepare($str);
  $query->bindValue(':mail', $mail, PDO::PARAM_STR);
  $query->execute();

  if($query->rowCount() > 0){
    return $query->fetch(PDO::FETCH_ASSOC);
  }
  return false;
}


?>