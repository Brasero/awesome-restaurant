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

$types = getAllType($bdd->connection);

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
        <div class="table">Type ingredient Liste</div>
        <div class="table">Ingredient liste</div>
    </div>
</div>

<script type="text/javascript" src="./assets/js/priceCheck.js"></script>

<script type="text/javascript" src="./assets/js/toastController.js"></script>