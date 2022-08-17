<?php

//require du controller de la page
require_once('../../controller/dash/ingredientController.php');


//Soummission du formulaire ajout de type d'ingrédient
if(isset($_POST['ingredientTypeNom']) && !empty($_POST['ingredientTypeNom'])){
    echo addTypeIngredient($bdd->connection, $_POST['ingredientTypeNom']);
}

//Soummission du formulaire ajout d'ingrédient
if(isset($_POST['ingredientNom'], $_POST['ingredientType'], $_POST['ingredientPrix'])){
    echo addNewIngredient($bdd->connection, $_POST);
}

//Soummission du formulaire modal d'update type ingrédient
if(isset($_POST['ingredientTypeIdUpdate'], $_POST['ingredientTypeNomUpdate']) && !empty($_POST['ingredientTypeNomUpdate'])){
    echo updateTypeIngredientName($bdd->connection, $_POST);
}

//Recupération de tout les type !!!! Efféctué après toute insertion ou modification au dessus
$types = getAllType($bdd->connection);
$ingredients = getAllIngredient($bdd->connection);
?>

<div class="ingredientContainer">
    <h1 class="ingredientTitle">
        Gestion des ingrédients
    </h1>
    <div class="ingredientCardDeck">
        <div class="card">
        <h4 class="formTitle">
                Ajouter un ingrédient
            </h4>
            <form action="" method="post">
                <div class="inputGroup">
                    <label for="ingredientNom" class="inputLabel">
                        <input type="text" class="inputItem" name="ingredientNom"
                        id="ingredientNom" placeholder="Nom" required />
                        <span>Nom</span>
                    </label>
                </div>
                <div class="inputGroup">
                    <label for="ingredientPrix" class="inputLabel">
                        <input type="text" class="inputItem" name="ingredientPrix"
                        id="ingredientPrix" placeholder="Prix" required onkeypress="checkPrice(event); return false;" />
                        <span>Prix</span>
                    </label>
                </div>
                <div class="typeChoice">
                    <label for="ingredientType">
                        <span>Type d'ingrédient</span>
                    </label>
                    <select 
                    class="inputItem" name="ingredientType"
                    id="ingredientType" placeholder="Type d'ingrédient" default="false" required>
                        <option class="typeOption" value="false">....</option>
                        <?php foreach ($types as $type){ ?>
                            <option value="<?= $type['id'] ?>"><?= $type['nom'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <button type="submit" class="addButton">
                    Ajouter
                </button>
            </form>
        </div>
        <div class="card">
            <h4 class="formTitle">
                Ajouter type d'ingrédient
            </h4>
            <form action="" method="post">
                <div class="inputGroup">
                    <label for="ingredientTypeNom" class="inputLabel">
                        <input type="text" class="inputItem" name="ingredientTypeNom"
                        id="ingredientTypeNom" placeholder="Nom" required />
                        <span>Nom</span>
                    </label>
                </div>
                <button type="submit" class="addButton">
                    Ajouter
                </button>
            </form>
        </div>
    </div>
    <div class="ingredientCardDeck">
        <!-- Liste ingrédient. -->
        <div class="table">
            <table class="ingredientTypeTable ingredientTableStyle">
                <h4 class="title" style="padding: 20px 15px; text-align: center;">
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
                    
                    <?php foreach($ingredients as $ingredient){ ?>
                        <tr class="ingredientTypeItem" 
                            id="ingredient-<?= $ingredient['id'] ?>" >

                            <td class="ingredientTypePart">
                                <?= $ingredient['nom'] ?>
                            </td>
                            <td class="ingredientTypePart">
                                <?= $ingredient['prix'] ?>
                            </td>
                            <td class="ingredientTypePart">
                                <?= intval($ingredient['dispo']) == 1 ? 
                                        "<span class='itemDisponible'></span>"
                                    :
                                        "<span class='itemIndisponible'></span>"
                                ?>
                            </td>
                            <td class="ingredientTypePart">
                                <?= $ingredient['type'] ?>
                            </td>
                            <td class="ingredientTypePart buttonGroup">
                                <button class="actionButton updateButton" onclick="openModal(event ,'ingredient', <?= $ingredient['id'] ?>)"
                                data-nomingredient="<?= $ingredient['nom'] ?>" 
                                data-prixingredient="<?= $ingredient['prix'] ?>">
                                    Modifier
                                </button>
                                <button class="actionButton deleteButton" onclick="supprItem('ingredient', <?= $ingredient['id'] ?>)">
                                    Supprimer
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- Fin liste ingrédient -->

        <!-- Liste types ingrédients -->
        <div class="table">
            <table class="ingredientTypeTable ingredientTableStyle">
                <h4 class="title" style="padding: 20px 15px; text-align: center;">
                    Liste type ingrédient
                </h4>
                <tbody>
                    <tr class="colonneTitleContainer">
                        <th class="colonneTitleItem">Nom</th>
                        <th class="colonneTitleItem">Action</th>
                    </tr>
                    
                    <?php foreach($types as $type){ ?>
                        <tr class="ingredientTypeItem" 
                            id="type-<?= $type['id'] ?>" >

                            <td class="ingredientTypePart">
                                <?= $type['nom'] ?>
                            </td>
                            <td class="ingredientTypePart buttonGroup">
                                <button class="actionButton updateButton" onclick="openModal(event ,'type', <?= $type['id'] ?>)"
                                data-nomtype="<?= $type['nom'] ?>">
                                    Modifier
                                </button>
                                <button class="actionButton deleteButton" onclick="supprItem('typeIngredient', <?= $type['id'] ?>)">
                                    Supprimer
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Fin liste type ingredient -->

    </div>
</div>


<!-- Emplacement des modal de modification -->
<div class="modalContainer hiddenModal">
    <div class="modalUpdateType">
        <div class="modalHead">
            <div class="modalTitle">
                Modifier un type d'ingrédient
            </div>
            <button class="closeModalButton" onclick="closeModal()">
                &times;
            </button>
        </div>
        <div class="modalBody">
            <form action="" method="POST" class="updateTypeForm">
                <input type="hidden" id="ingredientTypeIdUpdate" name="ingredientTypeIdUpdate" value="">
                <div class="inputGroup">
                    <label for="ingredientTypeNomUpdate" class="inputLabel">
                        <input type="text" class="inputItem" name="ingredientTypeNomUpdate"
                        id="ingredientTypeNomUpdate" value="" placeholder="Nom" required />
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

<!-- FIN emplacement des modal de modification -->

<script type="text/javascript" src="./assets/js/priceCheck.js"></script>

<script type="text/javascript" src="./assets/js/toastController.js"></script>

<script type="text/javascript" src="./assets/js/controlModalIngredient.js"></script>
<script type="text/javascript" src="./assets/js/suppressionAjax.js"></script>