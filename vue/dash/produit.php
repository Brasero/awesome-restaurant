<?php

// require du controller de la page 
require_once('../../controller/dash/produitController.php');

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
?>

<div class="produitContainer">
    <h1 class="produitTitle">
        Gestion des produits
    </h1>
    <div class="produitCardDeck">
        <div class="card">
            <h4 class="formTitle">
                Ajouter un produit
            </h4>
            <form action="" method="POST">
                <div class="inputGroup">
                    <label for="produitNom" class="inputLabel">
                        <input type="text" class="inputItem" name="produitNom" id="ingredientNom" placeholder="Nom" required />
                        <span>Nom</span>
                    </label>
                </div>
                <div class="inputGroup">
                    <label for="produitPrix" class="inputLabel">
                        <input type="text" class="inputItem" name="produitPrix" id="produitPrix" placeholder="Prix" required />
                        <span>Prix</span>
                    </label>
                </div>
                <div class="typeChoice">
                    <label for="categorieType">
                        <span>Catégorie</span>
                    </label>
                    <select name="categorieType" id="categorieType" class="inputItem" placeholder="C    ategorie" default="false" required>
                        <option value="false" class="typeOption">....</option>
                        <?php foreach ($categories as $categorie) { ?>
                            <option value="<?= $categorie['id'] ?>"><?= $categorie['nom'] ?></option>
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