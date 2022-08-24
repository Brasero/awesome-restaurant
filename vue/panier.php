<?php
require_once('../controller/panierController.php');
$panier = getPanier($bdd->connection);
$total = 0;
?>

<div></div>

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
                    <a href="index.php?page=panier&action=decreaseProd&idProd=<?= $item['ID_produit'] ?>" >
                        <span class="decreaseButton">
                            <button role="button" id="<?= $item['ID_produit'] ?>-minus">-</button>
                        </span>
                    </a>
                        <?= $item['qte_panier_ligne'] ?>
                    <a href="index.php?page=panier&action=increaseProd&idProd=<?= $item['ID_produit'] ?>">
                        <span class="increaseButton">
                            <button role="button" id="<?= $item['ID_produit'] ?>-plus">+</button>
                        </span>
                    </a>
                </div>
                <div class="action">
                    <a href="index.php?page=panier&action=supprProd&idProd=<?= $item['ID_produit'] ?>">
                        <button class="deleteButton" id="<?= $item['ID_produit'] ?>-delete">
                            Supprimer
                        </button>
                    </a>
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