<?php

use Model\Dash\IngredientManager;
use Model\Dash\IngredientTypeManager;

//require du controller de la page

require_once('../../controller/dash/ingredientController.php');


//Création d'un manager de type d'ingrédient
$ingredientTypeManager = new IngredientTypeManager($bdd->connection);

//Création d'un manager d'ingrédient
$ingredientManager = new IngredientManager($bdd->connection);

//Soummission du formulaire ajout de type d'ingrédient
if (isset($_POST['nom_type_ingredient']) && !empty($_POST['nom_type_ingredient'])) {
    echo $ingredientTypeManager->createNew($_POST);
}

//Soummission du formulaire ajout d'ingrédient
if (isset($_POST['nom_ingredient'], $_POST['ID_type_ingredient'], $_POST['prix_ingredient'])) {
    echo $ingredientManager->createNew($_POST);
}

//Soummission du formulaire modal d'update type ingrédient
if(isset($_POST['ID_type_ingredient'], $_POST['ingredientTypeNomUpdate']) && !empty($_POST['ingredientTypeNomUpdate'])){
    echo $ingredientTypeManager->update($_POST);
}

if (isset(
    $_POST['ingredientNomUpdate'],
    $_POST['ingredientPrixUpdate'],
    $_POST['ingredientType'],
    $_POST['ingredientIdUpdate']
)) {
    echo $ingredientManager->update($_POST);

}


//Recupération de tout les type !!!! Efféctué après toute insertion ou modification au dessus

//appel des types
$types = $ingredientTypeManager->getAll();
$ingredients = $ingredientManager->getAll();

?>

<div class="ingredientContainer">
    <h1 class="pageTitle">
        <span class="top" style="transform: translateY(-30px);">Gestion des</span>
        <span class="bottom" style="transform: translateY(30px);">ingrédients</span>
    </h1>
    <div class="ingredientCardDeck">
        <div class="card">
            <h4 class="formTitle">
                Ajouter un ingrédient
            </h4>
            <form action="" method="post">
                <div class="inputGroup">
                    <label for="ingredientNom" class="inputLabel">
                        <input type="text" class="inputItem" name="nom_ingredient" id="ingredientNom" placeholder="Nom" required />
                        <span>Nom</span>
                    </label>
                </div>
                <div class="inputGroup">
                    <label for="ingredientPrix" class="inputLabel">
                        <input type="text" class="inputItem" name="prix_ingredient" id="ingredientPrix" placeholder="Prix" required onkeypress="checkPrice(event); return false;" />
                        <span>Prix</span>
                    </label>
                </div>
                <div class="typeChoice">
                    <label for="ingredientType">
                        <span>Type d'ingrédient</span>
                    </label>
                    <select class="inputItem" name="ID_type_ingredient" id="ingredientType" placeholder="Type d'ingrédient" default="false" required>
                        <option class="typeOption" value="false">....</option>
                        <?php foreach ($types as $type) { ?>
                            <option value="<?= $type->getID() ?>"><?= $type->getNom() ?></option>
                        <?php } ?>
                    </select>
                </div>
                <button type="submit" class="addButton">
                    Ajouter
                </button>
            </form>
        </div>

 <!-- Liste ingrédient. -->
 
         <div class="table">
            <table class="ingredientTypeTable ingredientTableStyle">
                <h4 class="title">
                    Liste ingrédients
                </h4>
                <tbody>
                    <tr class="colonneTitleContainer">
                        <th class="colonneTitleItem">Nom</th>
                        <th class="colonneTitleItem">Prix</th>
                        <th class="colonneTitleItem">Disponibilité</th>
                        <th class="colonneTitleItem">Type</th>
                        <th class="colonneTitleItem">Action</th>
                    </tr>

                    <?php foreach ($ingredients as $ingredient) { ?>
                        <tr class="ingredientTypeItem" id="ingredient-<?= $ingredient->getID() ?>">

                            <td class="ingredientTypePart">
                                <?= $ingredient->getNom() ?>
                            </td>
                            <td class="ingredientTypePart">
                                <?= number_format($ingredient->getPrix(), 2, ',', '.') ?> €
                            </td>
                            <td class="ingredientTypePart">
                                <?= intval($ingredient->getDispo()) == 1 ?
                                    "<span class='itemDisponible'></span>"
                                    :
                                    "<span class='itemIndisponible'></span>"
                                ?>
                            </td>
                            <td class="ingredientTypePart">

                                <?php
                                foreach ($types as $type) {
                                    if ($ingredient->getId_type() == $type->getID()) {
                                        echo $type->getNom();
                                    }
                                }
                                ?>
                            </td>
                            <td class="ingredientTypePart buttonGroup">
                                <button class="actionButton updateButton" onclick="openModal(event ,'ingredient', <?= $ingredient->getId() ?>)" >
                                    <i class="bi bi-pencil-square"
                                        data-nomingredient="<?= $ingredient->getNom() ?>" 
                                        data-prixingredient="<?= $ingredient->getPrix() ?>" 
                                        data-dispoingredient="<?= $ingredient->getDispo() ?>" 
                                        data-idtypeingredient="<?= $ingredient->getId_type() ?>"
                                    ></i>
                                </button>
                                <button class="actionButton deleteButton" onclick="supprItem('ingredient', <?= $ingredient->getID() ?>)">
                                    Supprimer
                                </button>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
<!-- Fin liste ingrédient -->
    </div>
    <div class="ingredientCardDeck">
        <!-- Liste types ingrédients -->
        <div class="table">
            <table class="ingredientTypeTable ingredientTableStyle">
                <h4 class="title">
                    Liste type ingrédient
                </h4>
                <tbody>
                    <tr class="colonneTitleContainer">
                        <th class="colonneTitleItem">Nom</th>
                        <th class="colonneTitleItem">Action</th>
                    </tr>

                    <?php foreach ($types as $type) { ?>
                        <tr class="ingredientTypeItem" id="type-<?= $type->getID() ?>">

                            <td class="ingredientTypePart">
                                <?= $type->getNom() ?>
                            </td>
                            <td class="ingredientTypePart buttonGroup">
                                <button class="actionButton updateButton" onclick="openModal(event ,'type', <?= $type->getID() ?>)" data-nomtype="<?= $type->getNom() ?>">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="actionButton deleteButton" onclick="supprItem('typeIngredient', <?= $type->getID() ?>)">
                                    Supprimer
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
 <!-- Fin liste type ingredient -->
        <div class="card">
            <h4 class="formTitle">
                Ajouter type d'ingrédient
            </h4>
            <form action="" method="post">
                <div class="inputGroup">
                    <label for="ingredientTypeNom" class="inputLabel">
                        <input type="text" class="inputItem" name="nom_type_ingredient" id="ingredientTypeNom" placeholder="Nom" required />
                        <span>Nom</span>
                    </label>
                </div>
                <button type="submit" class="addButton">
                    Ajouter
                </button>
            </form>
        </div>

    </div>
</div>


<!-- Emplacement des modal de modification -->

<!-- MODAL Modification Type ingredient -->
<div class="modalContainer hiddenModal" id="modalTypeIngredient">
    <div class="modalUpdateType">
        <div class="modalHead">
            <div class="modalTitle">
                Modifier un type d'ingrédient
            </div>
            <button class="closeModalButton" onclick="closeModalType()">
                &times;
            </button>
        </div>
        <div class="modalBody">
            <form action="" method="POST" class="updateTypeForm">
                <input type="hidden" id="ingredientTypeIdUpdate" name="ID_type_ingredient" value="">
                <div class="inputGroup">
                    <label for="ingredientTypeNomUpdate" class="inputLabel">
                        <input type="text" class="inputItem" name="ingredientTypeNomUpdate" id="ingredientTypeNomUpdate" value="" placeholder="Nom" required />
                        <span>Nom</span>
                    </label>
                </div>
                <button type="submit" class="addButton">
                    Modifier
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Fin Modal modification type ingredient -->

<!-- Modal modification ingredient -->

<div class="modalContainer hiddenModal" id="modalIngredient">
    <div class="modalUpdateType">
        <div class="modalHead">
            <div class="modalTitle">
                Modifier un ingrédient
            </div>
            <button class="closeModalButton" onclick="closeModalIngredient()">
                &times;
            </button>
        </div>
        <div class="modalBody">
            <form action="" method="POST" class="updateTypeForm">
                <input type="hidden" id="ingredientIdUpdate" name="ingredientIdUpdate" value="">
                <div class="inputGroup">
                    <label for="ingredientNomUpdate" class="inputLabel">
                        <input type="text" class="inputItem" name="ingredientNomUpdate" id="ingredientNomUpdate" value="" placeholder="Nom" required />
                        <span>Nom</span>
                    </label>
                </div>
                <div class="inputGroup">
                    <label for="ingredientPrixUpdate" class="inputLabel">
                        <input type="text" class="inputItem" name="ingredientPrixUpdate" id="ingredientPrixUpdate" value="" placeholder="Prix" required />
                        <span>Prix</span>
                    </label>
                </div>
                <label for="ingredientDispoUpdate" class="dispoLabel">
                    <input type="checkbox" name="ingredientDispoUpdate" id="ingredientDispoUpdate">
                    <span class="circleOnOff">
                        <span class="onOffTick"></span>
                    </span>
                </label>
                <div class="typeChoice">
                    <label for="ingredientTypeModif">
                        <span>Type d'ingrédient</span>
                    </label>
                    <select class="inputItem" name="ingredientType" id="ingredientTypeModif" placeholder="Type d'ingrédient" default="false" required>
                        <option class="typeOption" value="false">....</option>
                        <?php foreach ($types as $type) { ?>
                            <option id="ingredientTypeModifOption-<?= $type->getID() ?>" value="<?= $type->getID() ?>"><?= $type->getNom() ?></option>

                        <?php } ?>
                    </select>
                </div>
                <button type="submit" class="addButton">
                    Modifier
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Fin modal modification ingredient -->

<!-- FIN emplacement des modal de modification -->

<script type="text/javascript" src="./assets/js/priceCheck.js"></script>

<script type="text/javascript" src="./assets/js/toastController.js"></script>
<script type="text/javascript" src="./assets/js/controlModal.js"></script>

<script type="text/javascript" src="./assets/js/suppressionAjax.js"></script>
<script type="text/javascript" src="./assets/js/animation.js"></script>