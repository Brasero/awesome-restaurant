<?php

use Model\Dash\TaxeManager;
use Model\Dash\ProduitManager;
use Model\Dash\CategorieManager;
use Model\Dash\IngredientManager;
use Model\Dash\IngredientTypeManager;

// require du controller de la page 
require_once('../../controller/dash/produitController.php');
require_once('../../controller/dash/ingredientController.php');

$produitManager = new ProduitManager($bdd->connection);
$categorieManager = new CategorieManager($bdd->connection);
$ingredientManager = new IngredientManager($bdd->connection);
$ingredientTypeManager = new IngredientTypeManager($bdd->connection);
$taxeManager = new TaxeManager($bdd->connection);
$produit9 = $produitManager->getAll();

// Soummission du formulaire ajout de produit
if (isset($_POST['produitNom'], $_POST['produitPrix'], $_POST['categorie']) && !empty($_POST['produitNom']) && !empty($_POST['produitPrix']) && !empty($_POST['categorie'])) {
    echo addProduct($bdd->connection, $_POST);
}

// Soummission du formulaire ajout de catégorie
if (isset($_POST['Nom_categorie']) && !empty($_POST['Nom_categorie'])) {
    echo  $categorieManager->createNew($_POST);
}

//Soumission du formulaire modal d'update type catégorie
if (isset($_POST['categorieIdUpdate'], $_POST['categorieNomUpdate']) && !empty($_POST['categorieNomUpdate'])) {
    echo $categorieManager->update($_POST);
}

// Soummission du formulaire ajout de taxe
if (isset($_POST['TaxeLitterale_taxe']) && !empty($_POST['TaxeLitterale_taxe'])) {
    echo  $taxeManager->createNew($_POST);
}

//Soumission du formulaire modal d'update type catégorie
if (isset($_POST['taxeIdUpdate'], $_POST['taxeTauxUpdate']) && !empty($_POST['taxeTauxUpdate'])) {
    echo $taxeManager->update($_POST);
}

//Récupération de toute les catégorie! Efféctué après toute insertion ou modification au dessus
$categories = $categorieManager->getAll();
$ingredients = $ingredientManager->getAll();
$types = $ingredientTypeManager->getAll();
$taxes = $taxeManager->getAll();

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
                                <option value="<?= $categorie->getID() ?>"><?= $categorie->getNom() ?></option>
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

                        <?php foreach ($types as $type) : ?>
                            <div class="typeIngredientGroupItem" id="type-<?= $type->getID() ?>" onclick="toggleIngredientList(event,<?= $type->getID() ?>)" data-idtype="<?= $type->getID() ?>">
                                <div class="groupLabel">
                                    <span><?= $type->getNom() ?></span> <i class="bi bi-caret-down-fill"></i>
                                </div>

                                <?php foreach ($ingredients as $ingredient) :
                                    if ($ingredient->getId_type() == $type->getID()) : ?>
                                        <div class="groupItem">
                                            <input type="checkbox" name="ingredients[]" value="<?= $ingredient->getID() ?>" id="ingredient-<?= $ingredient->getNom(); ?>">
                                            <label for="ingredient-<?= $ingredient->getNom() ?>" class="ingredientLabel"><?= $ingredient->getNom() ?></label>
                                        </div>
                                <?php endif;
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
        <div class="table">
            <table class="categorieTypeTable categorieTableStyle">
                <h4 class="title">
                    Liste categorie
                </h4>
                <tbody>
                    <tr class="colonneTitleContainer">
                        <th class="colonneTitleItem">Nom
                        </th>
                        <th class="colonneTitleItem">Action</th>
                    </tr>
                    <?php foreach ($categories as $categorie) { ?>
                        <tr class="categorieTypeItem" id="categorie-<?= $categorie->getID() ?>">
                            <td class="categorieTypePart"><?= $categorie->getNom() ?>
                            </td>
                            <td class="categorieTypePart buttonGroup">
                                <button class="actionButton updateButton" onclick="openModal(event, 'categorie', <?= $categorie->getID() ?>)" >
                                    <i class="bi bi-pencil-square"
                                         data-nomcategorie="<?= $categorie->getNom() ?>">
                                    </i>
                                </button>
                                <button class="actionButton deleteButton" onclick="supprItem('categorie', <?= $categorie->getID() ?>)">
                                    Supprimer
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="produitCardDeck">
        <div class="table">Produit liste</div>

         <div class="card">
            <h4 class="formTitle">
                Ajouter categorie
            </h4>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="inputGroup">
                    <label for="categorieNom" class="inputLabel">
                        <input type="text" class="inputItem" name="Nom_categorie" id="categorieNom" placeholder="Nom" required />
                        <span>Nom</span>
                    </label>
                </div>
                <span class="inputGroup">
                    <label for="image" class="inputLabel">
                        <input type="hidden" name="MAX_FILE_SIZE" value="20000000" />
                        <input type="file" class="inputItem" name="image" id="image" placeholder="Image" required />
                        <span>Image</span>
                    </label>
                </span>
                <button type="submit" class="addButton">
                    Ajouter
                </button>
            </form>
        </div>
    </div>
    <div class="produitCardDeck">
        <!-- debut form taux -->
        <div class="card">
            <h4 class="formTitle">
                Ajouter taxe
            </h4>
            <form action="" method="POST" >
                <div class="inputGroup">
                    <label for="TaxeLitterale_taxe" class="inputLabel">
                        <input type="number" step="0.1" min="0" max="100" class="inputItem" name="TaxeLitterale_taxe" id="TaxeLitterale_taxe" placeholder="Nom" required />
                        <span>Taux</span>
                    </label>
                </div>
                <button type="submit" class="addButton">
                    Ajouter
                </button>
            </form>
        </div>
            <div class="table">
            <table class="categorieTypeTable categorieTableStyle">
                <h4 class="title" style="padding:
                20px 15px; text-align: center;">
                    TVA
                </h4>
                <tbody>
                    <tr class="colonneTitleContainer">
                        <th class="colonneTitleItem">Nom
                        </th>
                        <th class="colonneTitleItem">Action</th>
                    </tr>
                    <?php foreach ($taxes as $taxe) { ?>
                        <tr class="categorieTypeItem" id="taxe-<?= $taxe->getID() ?>">
                            <td class="categorieTypePart"><?= $taxe->getTaxeTolitteral() ?>
                            </td>
                            <td class="categorieTypePart buttonGroup">
                                <button class="actionButton updateButton" onclick="openModal(event,'taxe', <?= $taxe->getId() ?>)" data-tauxTaxe="<?=$taxe->getTaxePourcent() ?>">
                                    Modifier
                                </button>
                                <button class="actionButton deleteButton" onclick="supprItem('taxe', <?= $taxe->getId() ?>)">
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
<div class="modalContainer hiddenModal" id="modalCategorie">
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
<!-- Emplacement du modal de modification des taxe -->
<div class="modalContainer hiddenModal" id="modalTaxe">
    <div class="modalUpdateType">
        <div class="modalHead">
            <div class="modalTitle">
                Modifier une taxe
            </div>
            <button class="closeModalButton" onclick="closeModalTaxe()">
                &times;
            </button>
        </div>
        <div class="modalBody">
            <form action="" method="POST" class="uptadeTypeForm">
                <input type="hidden" id="taxeIdUpdate" name="taxeIdUpdate" value="">
                <div class="inputGroup">
                    <label for="taxeTauxUpdate" class="inputLabel">
                        <input type="number" min="0" max="100" step="0.1" class="inputItem" name="taxeTauxUpdate" id="taxeTauxUpdate" value="" placeholder="Taux" required />
                        <span>Taux</span>
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