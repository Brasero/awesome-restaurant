<?php
require('../controller/inscriptionController.php');
?>



<div class="inscriptionContainer">
  <form action="" method="POST" class="signForm">
    <input type="text" name="nom" id="" placeholder="Nom" class="signInput">
    <input type="email" name="mail" id="" placeholder="Mail" class="signInput">
    <input type="password" name="mdp" placeholder="Mdp" id="" class="signInput">
    <button type="submit" class="signButton">
      S'inscrire
    </button>
  </form>
</div>