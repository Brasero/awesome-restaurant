<?php
require('../controller/inscriptionController.php');

if(isset($_POST['nom'])){
  echo createNewUser($bdd->connection, $_POST);
}
?>



<div class="inscriptionContainer">
  <form action="" method="POST" class="signForm">
    <h1 class="formTitle">Inscrivez-vous</h1>
    <div class="inputGroup">
      <label for="nom" class="inputLabel">
        <input type="text" class="signInput" id="nom" name="nom" placeholder="Nom">
        <span>Nom</span>
      </label>
    </div>
    <div class="inputGroup">
      <label for="prenom" class="inputLabel">
        <input type="text" class="signInput" id="prenom" name="prenom" placeholder="Prénom">
        <span>Prénom</span>
      </label>
    </div>
    <div class="inputGroup">
      <label for="tel" class="inputLabel">
        <input type="number" class="signInput" id="tel" name="tel" placeholder="Portable">
        <span>Portable</span>
      </label>
    </div>
    <div class="inputGroup">
      <label for="email" class="inputLabel">
        <input type="text" class="signInput" id="email" name="email" placeholder="E-mail">
        <span>Email</span>
      </label>
    </div>
    <div class="inputGroup">
      <label for="confirmEmail" class="inputLabel">
        <input type="text" class="signInput" id="confirmEmail" name="confirmEmail" placeholder="Confirmez votre email">
        <span>Confirmez votre email</span>
      </label>
    </div>
    <div class="adresseFormContainer">
      <div class="adresseNumberAndPrefix">
        <div class="inputGroup">
          <label for="adresseNumber" class="inputLabel">
            <input type="text" class="signInput" id="adresseNumber" name="adresseNumber" placeholder="N°" autocomplete="addresse-line3">
            <span>N°</span>
          </label>
        </div>
        <div class="inputGroup">
          <label for="adressePrefix" class="inputLabel">
            <input type="text" class="signInput" id="adressePrefix" name="adressePrefix" placeholder="Rue" autocomplete="address-line2">
            <span>Rue, Voie, ...</span>
          </label>
        </div>
        <div class="inputGroup">
          <label for="adresseName" class="inputLabel">
            <input type="text" class="signInput" id="adresseName" name="adresseName" placeholder="Nom de voie" autocomplete="address-line1">
            <span>Nom de la voie</span>
          </label>
        </div>
      </div>
      <div class="inputGroup">
        <label for="adresseComplement" class="inputLabel">
          <input type="text" class="signInput" id="adresseComplement" name="adresseComplement" placeholder="Complement d'adresse (facultatif)" autocomplete="address-line4">
          <span>Complément d'adresse (facultatif)</span>
        </label>
      </div>
      <div class="villeAndCp">
        <div class="inputGroup">
          <label for="adresseVille" class="inputLabel">
            <input type="text" class="signInput" id="adresseVille" name="adresseVille" placeholder="Ville" autocomplete="address-level2"
            onkeyup="getVilleByName()" 
            onfocus="closeProp()"
            >
            <span>Ville</span>
          </label>
          <div class="proposition" id="villeProp"></div>
        </div>
        <div class="inputGroup">
          <label for="adresseCp" class="inputLabel">
            <input type="text" class="signInput" id="adresseCp" name="adresseCp" placeholder="Code postal" autocomplete="postal-code"
            onkeyup="getVilleByCp()"
            onfocus="closeProp()">
            <span>Code postal</span>
          </label>
          <div class="proposition" id="cpProp"></div>
        </div>
      </div>
      <div class="passwordGroup">
        <div class="inputGroup">
          <label for="mdp" class="inputLabel">
            <input type="password" name="mdp" id="mdp" placeholder="Mot de passe" class="signInput">
            <span>Mot de passe</span>
          </label>
        </div>
        <div class="inputGroup">
          <label for="confirmMdp" class="inputLabel">
            <input type="password" name="confirmMdp" id="confirmMdp" placeholder="Confirmer mot de passe" class="signInput">
            <span>Confirmer mot de passe</span>
          </label>
        </div>
      </div>
    </div>
    <button type="submit" class="signButton">
      M'inscrire
    </button>
  </form>
</div>

<script type="text/javascript" src="./assets/js/ville.js"></script>