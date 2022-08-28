<?php

// require du controller de la page 
require_once('../../controller/dash/produitController.php');
require_once('../../controller/dash/ingredientController.php');
require_once('../../controller/dash/Produit.php');
require_once('../../model/dash/ProduitManager.php');
require_once('../../model/dash/CategorieManager.php');
require_once('../../controller/dash/Categorie.php');
require_once('../../model/dash/IngredientManager.php');
require_once('../../controller/dash/Ingredient.php');

$prodManager = new ProduitManager($bdd->connection);

$produit9 = $prodManager->getProduits();

var_dump($produit9[0]->ingredients);

foreach($produit9 as $prod){
    echo $prod->getNom();
}

// Soummission du formulaire ajout de produit
if(isset($_POST['produitNom'], $_POST['produitPrix'], $_POST['categorie']) && !empty($_POST['produitNom']) && !empty($_POST['produitPrix']) && !empty($_POST['categorie'])){
    echo addProduct($bdd->connection, $_POST);
}

// Soummission du formulaire ajout de catégorie
if (isset($_POST['categorieNom']) && !empty($_POST['categorieNom'])) {
    echo addCategorie($bdd->connection, $_POST['categorieNom']);
}

//Soumission du formulaire modal d'update type ingrédient
if (isset($_POST['categorieIdUpdate'], $_POST['categorieNomUpdate']) && !empty($_POST['categorieNomUpdate'])) {
    echo updateCategorieName($bdd->connection, $_POST);
}

//Récupération de toute les catégorie! Efféctué après toute insertion ou modification au dessus
$categories = getAllCategorie($bdd->connection);
$ingredients = getAllIngredient($bdd->connection);
$types = getAllType($bdd->connection);
?>

<div class="produitContainer">
    <h1 class="pageTitle">
        <span class="top" style="transform: translateY(-30px);">Gestion des</span>
        <span class="bottom" style="transform: translateY(30px);">produits</span>
    </h1>
    <div class="produitCardDeck">
        <div class="card">
            <h4 class="formTitle">
                Ajouter un produit
            </h4>
            <form action="" method="POST" class="produitFormContainer">
                <span class="produitFormPart1">
                    <span class="inputGroup">
                        <label for="produitNom" class="inputLabel">
                            <input type="text" class="inputItem" name="produitNom" id="ingredientNom" placeholder="Nom" required />
                            <span>Nom</span>
                        </label>
                    </span>
                    <span class="inputGroup">
                        <label for="produitPrix" class="inputLabel">
                            <input type="text" class="inputItem" name="produitPrix" id="produitPrix" placeholder="Prix" required />
                            <span>Prix</span>
                        </label>
                    </span>
                    <span class="typeChoice">
                        <label for="categorieType">
                            <span>Catégorie</span>
                        </label>
                        <select name="categorie" id="categorieType" class="inputItem" placeholder="C    ategorie" default="false" required>
                            <option value="false" class="typeOption">....</option>
                            <?php foreach ($categories as $categorie) { ?>
                                <option value="<?= $categorie['id'] ?>"><?= $categorie['nom'] ?></option>
                            <?php } ?>
                        </select>
                    </span>
                    <button type="button" onclick='switchForm("toLeft")' class="addButton">
                        Suivant
                    </button>
                </span>
                <span class="produitFormPart2">
                    <button class="backButton" type="button" onclick="switchForm('toRight')"><i class="bi bi-arrow-left-short"></i>Retour</button>
                    <fieldset class="ingredientGroup">

                        <?php foreach($types as $type): ?>
                            <div class="typeIngredientGroupItem" id="type-<?= $type['id'] ?>" onclick="toggleIngredientList(event,<?= $type['id'] ?>)" data-idtype="<?= $type['id'] ?>">
                                <div class="groupLabel">
                                    <span><?= $type['nom'] ?></span> <i class="bi bi-caret-down-fill"></i>
                                </div>
                                
                                    <?php foreach($ingredients as $ingredient): 
                                            if($ingredient['idType'] == $type['id']): ?>
                                            <div class="groupItem">
                                                <input type="checkbox" name="ingredients[]" value="<?= $ingredient['id'] ?>" id="ingredient-<?= $ingredient['nom']; ?>">
                                                <label for="ingredient-<?= $ingredient['nom'] ?>" class="ingredientLabel"><?= $ingredient['nom'] ?></label>
                                            </div>
                                    <?php   endif; 
                                        endforeach; ?>
                                
                            </div>
                        <?php endforeach; ?>

                    </fieldset>
                    <button type="submit" class="addButton">
                        Valider
                    </button>

                </span>
            </form>
        </div>
        <div class="card">
            <h4 class="formTitle">
                Ajouter categorie
            </h4>
            <form action="" method="POST">
                <div class="inputGroup">
                    <label for="categorieNom" class="inputLabel">
                        <input type="text" class="inputItem" name="categorieNom" id="categorieNom" placeholder="Nom" required />
                        <span>Nom</span>
                    </label>
                </div>
                <button type="submit" class="addButton">
                    Ajouter
                </button>
            </form>
        </div>
    </div>
    <div class="produitCardDeck">
        <div class="table">Produit liste</div>
        <div class="table">
            <table class="categorieTypeTable categorieTableStyle">
                <h4 class="title" style="padding:
                20px 15px; text-align: center;">
                    Liste categorie
                </h4>
                <tbody>
                    <tr class="colonneTitleContainer">
                        <th class="colonneTitleItem">Nom
                        </th>
                        <th class="colonneTitleItem">Action</th>
                    </tr>
                    <?php foreach ($categories as $categorie) { ?>
                        <tr class="categorieTypeItem" id="categorie-<?= $categorie['id'] ?>">
                            <td class="categorieTypePart"><?= $categorie['nom'] ?>
                            </td>
                            <td class="categorieTypePart buttonGroup">
                                <button class="actionButton updateButton" onclick="openModal(event, 'categorie', <?= $categorie['id'] ?>)" data-nomcategorie="<?= $categorie['nom'] ?>">
                                    Modifier
                                </button>
                                <button class="actionButton deleteButton" onclick="supprItem('categorie', <?= $categorie['id'] ?>)">
                                    Supprimer
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Emplacement des modal de modofication -->
<div class="modalContainer hiddenModal">
    <div class="modalUpdateType">
        <div class="modalHead">
            <div class="modalTitle">
                Modifier une catégorie
            </div>
            <button class="closeModalButton" onclick="closeModalCategorie()">
                &times;
            </button>
        </div>
        <div class="modalBody">
            <form action="" method="POST" class="uptadeTypeForm">
                <input type="hidden" id="categorieIdUpdate" name="categorieIdUpdate" value="">
                <div class="inputGroup">
                    <label for="categorieNomUpdate" class="inputLabel">
                        <input type="text" class="inputItem" name="categorieNomUpdate" id="categorieNomUpdate" value="" placeholder="Nom" required />
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

<script type="text/javascript" src="./assets/js/controlModal.js"></script>

<script type="text/javascript" src="./assets/js/toastController.js"></script>
<script type="text/javascript" src="./assets/js/suppressionAjax.js"></script>

<script type="text/javascript" src="./assets/js/animation.js"></script>
<script type="text/javascript" src="./assets/js/dropDownIngredient.js"></script>
<script type="text/javascript" src="./assets/js/switchForm.js"></script>