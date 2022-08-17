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
                    <select name="categorieType" id="categorieType" class="inputItem" placeholder="Type de categorie" default="false" required>
                        <option value="false" class="typeOption">....</option>
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
                </tbody>
            </table>
        </div>
    </div>
</div>