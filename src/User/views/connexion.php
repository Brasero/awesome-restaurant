<?php
// require('../controller/connexionController.php');

// echo connectUser($bdd->connection, $_POST);
?>



<div class="connexionContainer">
  <form action="" method="POST" class="loginForm">
    <h1 class="loginTitle">
      Connexion
    </h1>
    <div class="inputGroup">
      <label for="mail" class="inputLabel">
      <input 
      type="email" 
      name="mail" 
      id="mail" 
      placeholder="Email" 
      class="signInput"
      >
        <span>Adresse Mail</span>
      </label>
    </div>

    <div class="inputGroup">
      <label for="mdp" class="inputLabel">
        <input type="password" name="mdp" placeholder="Mot de passe" id="mdp" class="signInput">
        <span>Mot de passe</span>
      </label>
    </div>
    
    
    
    <button type="submit" class="loginButton">
      Se connecter
    </button>

    <section class="choiceSeparator">
      <hr class="first">
      <span class="text">OU</span>
      <hr class="second">
    </section>

    <section class="socialConnexion__container">
      <h3 class="title">Se connecter avec :</h3>
      <div class="social__container">
        <button type="button">
          <img src="./assets/img/ressources/icon/facebook/facebook.png" alt="connexion facebook">
        </button>
        <button type="button">
          <img src="./assets/img/ressources/icon/google/google.png" alt="connexion google">
        </button>
      </div>
    </section>
  </form>

  <section class="hero__wrapper">
    <section class="hero__section">
      <span class="hero_icon__container">
        <img src="./assets/img/ressources/icon/user/carbon_user-avatar.png" alt="icon utilisateur">
      </span>
    </section>
    <section class="hero__section title">
      <span>
        Connectez 
      </span>
      <span>
        vous
      </span>
    </section>
    <section class="hero__section one">
      <span>
        Conservez votre 
      </span>
      <span>
        panier
      </span>
      <span>
        pour
      </span>
    </section>
    <section class="hero__section two">
      <span>
        plus tard ou bien
      </span>
      <span>
         faite vous
      </span>
    </section>
    <section class="hero__section three">
      <span>
        livrer
      </span>
    </section>
    <section class="hero__section footer">
      <img 
      src="./assets/img/ressources/icon/scooter/scooter@2.png" alt="icon utilisateur">
    </section>
  </section>
</div>