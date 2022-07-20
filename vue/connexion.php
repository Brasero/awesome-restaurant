<?php
require('../controller/connexionController.php');

connectUser($bdd->connection, $_POST);

?>



<div class="connexionContainer">
  <form action="" method="POST" class="loginForm">
    <input type="email" name="mail" id="" placeholder="Email" class="loginInput">
    <input type="password" name="mdp" placeholder="Mot de passe" id="" class="loginInput">
    <button type="submit" class="loginButton">
      Connexion
    </button>
  </form>
</div>