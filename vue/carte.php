<?php
require('../controller/panierController.php');
$produits = produitList($bdd->connection);
if (isset($_GET['addItem'])) {
  addItemToPanierById($bdd->connection, $_GET['addItem'], 1);
}
?>

<!-- titre + selecteur de categorie -->
<div class="cartContainer">
  <div class="selectCarte">
    <h1>Notre carte</h1>
     <select name="" id="selectCat">
      <option value="">burger</option>
    </select>
  </div>

<!-- debut boucle pour boucle categorie -->
  <div class="cardDeck">
    <h1>Categorie</h1>
    <span></span>
<!-- debut pour boucle produit -->
    <div class="cardProd">
      <img src="../public/assets/img/ressources/background/carte/test.png" alt="">
      <div> 
        <h2>Le burger 1</h2>
        <p>La liste des ingredient</p>
      </div>
      <div class="cardButtonGroup">
        <button class="cardButtonAdd">
         <iconify-icon id="cartIcone" icon="noto-v1:shopping-cart"></iconify-icon>
        </button>
        <button class="cardButtonAdd">
          +Ajouter 
        </button>
      </div>
    </div> 
  </div>
<!-- fin de boucle categorie et produit  -->

<!-- debut panier -->

  <div class="cardPanier">
    <h1>Mon panier</h1>
    <span></span>
<!-- debut boucle produit dans panier -->
    <div class="panierProd">
      <img src="../public/assets/img/ressources/background/carte/test.png" alt="" class="imageProdPanier">
      <p class="nomProduit">Nom produit</p>
      <p class="prixProduit">10.50</p>
      <span></span>
    </div>
  </div>

<!-- fin panier -->
<div class="panierToggle" onclick="togglePanier()">
  <div class="top"></div>
  <div class="bottom"></div>
</div>

</div>

<script src="../public/assets/js/togglePanier.js"></script>