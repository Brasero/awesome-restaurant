<?php
require('../controller/panierController.php');
$produits = produitList($bdd->connection);
if (isset($_GET['addItem'])) {
  addItemToPanierById($bdd->connection, $_GET['addItem'], 1);
}
?>


<div class="cartContainer">
  <div class="cardDeck">
    <?php
    if ($produits != false) {
      foreach ($produits as $produit) {
    ?>
        <div class="card">
          <span class="cardBadge">
            <?= number_format($produit['prix_produit'], 2, ',', '.') ?>€
          </span>
          <div class="cardImg"></div>
          <div class="cardOverlay">
            <div class="cardName">
              <?= ucfirst($produit['nom_produit']) ?>
            </div>
            <div class="cardButtonGroup">
              <a href="index.php?page=carte&addItem=<?= $produit['ID_produit'] ?>" class="cardButtonAddLink">
                <button class="cardButtonAdd">
                  +Ajouter
                </button>
              </a>
            </div>
          </div>
        </div>
    <?php
      }
    } else {
      echo 'aucun produit à afficher';
    }

    ?>
  </div>
</div>