<?php
require_once('../controller/panierController.php');
$panier = getPanier($bdd->connection);
$total = 0;
?>


<div class="panierContainer">
    <h1 class="panierTitle">
        Mon panier
    </h1>
    <?php if(isset($panier) && $panier != null || false){ ?>
    <ul class="itemList">
        <?php foreach($panier as $item){ 
            $total += $item['prix_produit']*$item['qte_panier_ligne'] ?>
            
            <li class="item">
                <div class="nameImage">
                    <img class="image" src="./assets/img/burger.jpg" />
                    <span class="name"><?= $item['nom_produit'] ?></span>
                </div>
                <div class="price">
                    <?= $item['prix_produit'] ?> €
                </div>
                <div class="qte">
                    <span class="decreaseButton">
                        <button role="button" id="<?= $item['ID_produit'] ?>-minus">-</button>
                    </span>
                        <?= $item['qte_panier_ligne'] ?>
                    <span class="increaseButton">
                        <button role="button" id="<?= $item['ID_produit'] ?>-plus">+</button>
                    </span>
                </div>
                <div class="action">
                    <button class="deleteButton" id="<?= $item['ID_produit'] ?>-delete">
                        Supprimer
                    </button>
                </div>
            </li>

        <?php } ?>
    </ul>
    <h2 class="total">
        Total : <?= $total ?> €
    </h2>
    <?php } else { ?>
        <h2 class="total">
            Votre panier est vide.
        </h2>
    <?php } ?>
</div>