<?php

require_once('../../controller/dash/adminConnexionController.php');

if(isset($_POST['mail'], $_POST['mdp'])){
    connectAdmin($bdd->connection, $_POST);
}

?>


<div class="connexionContainer">
  <div class="formContainer">
    <h1 class="formTitle">
        <div class="top">Administration</div>
        <div class="bottom"><span class="left">Burger</span> <span class="right">Compagny</span></div>
    </h1>
    <form action="" method="POST" class="loginForm">
      <div class="inputGroup">
        <label for="mail" class="inputLabel">
        <input type="email" name="mail" id="mail" placeholder="Email" class="signInput">
          <span>Email</span>
        </label>
      </div>

      <div class="inputGroup">
        <label for="mdp" class="inputLabel">
          <input type="password" name="mdp" placeholder="Mot de passe" id="mdp" class="signInput">
          <span>Mot de passe</span>
        </label>
      </div>
      
      
      
      <button type="submit" class="loginButton">
        Connexion
      </button>
    </form>
  </div>
</div>