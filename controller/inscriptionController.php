<?php

require('../model/userModel.php');

function newUser($bdd, $array){
  if(isset($array['nom'], $array['mail'], $array['mdp'])){
    $user['nom'] = strip_tags($array['nom']);
    $user['mail'] = strip_tags($array['mail']);
    $user['mdp'] = password_hash($array['mdp'], PASSWORD_BCRYPT);
    setNewUser($bdd, $user);
  }
}
?>