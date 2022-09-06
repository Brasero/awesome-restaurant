<?php

use Model\Dash\OffreManager;

$offreManager = new OffreManager($bdd->connection);


//Soumission du formulaire d'offre ADD
if(isset($_POST['nom_offre'], $_POST['taux_offre'], $_POST['date_debut_offre'], $_POST['date_fin_offre'])
    && !empty($_POST['nom_offre'])
    && !empty($_POST['taux_offre']) 
    && !empty($_POST['date_debut_offre']) 
    && !empty($_POST['date_fin_offre'])
) {
    echo $offreManager->createNew($_POST);
}

//Soumission du formulaire d'update d'offres
if(isset(
    $_POST['ID_offre_update'],
    $_POST['nom_offre_update'],
    $_POST['taux_offre_update'],
    $_POST['date_debut_offre_update'],
    $_POST['date_fin_offre_update']
    ) 
    && !empty($_POST['ID_offre_update'])
    && !empty($_POST['nom_offre_update'])
    && !empty($_POST['date_debut_offre_update'])
    && !empty($_POST['date_fin_offre_update'])){
        echo $offreManager->update($_POST);
    }


//Recupération des infos en bdd;
$offres  = $offreManager->getAll();
?>

<div class="container__dahsboard">
    <aside class="leftPart">
        <h1 class="pageTitle">
            <span class="top"></span>
            <span class="bottom" style="transform: translateY(30px);">
                Dashboard
            </span>
            <span class="message">
                <span class="hello">
                    Bonjour 
                </span>
                <span class="name">
                    <!---- Nom Admin  ------>
                    Brandon
                </span>
            </span>
        </h1>


        <!-- FIRST ROW WITH CARD -->
        <section class="row card__sm__wrapper">
            <div class="card__sm"></div>
            <div class="card__sm"></div>
            <div class="card__sm"></div>
            <div class="card__sm"></div>
        </section>

        <!-- END FIRST ROW WITH CARD -->
        <!--  SECOND ROW CARD --->
        <section class="row secondPartRow">
            <div class="col-4">
                <div class="col-row">
                    <div class="card__md"></div>
                </div>
                <div class="col-row">
                    <div class="card__md"></div>
                </div>
            </div>
            <div class="col-8">
                <div class="card__lg">
                    
                </div>
            </div>
        </section>
        <!-- END SECOND ROW CARD --->

        <section class="row">
            <div class="col-4">
                <div class="card__md__height">
                <form action="" method="POST" class="offreForm">
                        <span class="part formTitle">
                            Nouvelle offre
                        </span>
                        <span class="part">
                            <div class="inputGroup">
                                <label for="nom_offre" class="inputLabel">
                                    <input 
                                        type="text" 
                                        name="nom_offre" placeholder="Nom de l'offre"
                                        id="nom_offre" 
                                        required />
                                    <span>Nom de l'offre</span>
                                </label>
                            </div>
                        </span>
                        <span class="part"> <div class="inputGroup">
                                <label for="pourcentage_offre" class="inputLabel">
                                    <input 
                                        type="text" 
                                        name="taux_offre" placeholder="pourcentage de l'offre"
                                        id="pourcentage_offre" 
                                        required />
                                    <span>% de l'offre</span>
                                </label>
                            </div>
                        </span>
                        <div class="inputGroup">
                            <label for="date_debut_offre" class="inputLabel">
                                <input type="date" class="inputItem" name="date_debut_offre" id="date_debut_offre" value="" placeholder="Débute le :" required />
                                <span>Débute le :</span>
                            </label>
                        </div>
                        <div class="inputGroup">
                            <label for="date_fin_offre" class="inputLabel">
                                <input type="date" class="inputItem" name="date_fin_offre" id="date_fin_offre" value="" placeholder="Fin le :" required />
                                <span>Fin le :</span>
                            </label>
                        </div>
                        <span class="part">
                            <input type="submit" class="subButton" value="Ajouter">
                        </span>
                    </form>
                </div>
            </div>
            <div class="col-8">
                <div class="card__lg offre__card" style="flex-direction: column; justify-content: flex-start; overflow-y: auto;">
                    <theader class='tableTitle'>
                        Offres
                    </theader>
                    <table class="offreListTable">
                        <tbody>
                            <tr class="head tableRow">
                                <th class="part">Nom</th>
                                <th class="part">%</th>
                                <th class='part'>Etat</th>
                                <th class="part">Début</th>
                                <th class="part">Fin</th>
                                <th class="part">Action</th>
                            </tr>
                            <?php foreach($offres as $offre): ?>
                                <tr class="offreItem tableRow">
                                    <td class="offrePart">
                                        <?= $offre->getNom(); ?>
                                    </td>
                                    <td class="offrePart">
                                        <?= $offre->getTauxLitteral(); ?>
                                    </td>
                                    <td class="offrePart">
                                        <?php
                                            echo $offre->getEtat();  
                                        ?>
                                    </td>
                                    <td class="offrePart">
                                        <?= $offre->getDate_debutShort(); ?>
                                    </td>
                                    <td class="offrePart">
                                        <?= $offre->getDate_finShort(); ?>
                                    </td>
                                    <td class="offrePart">
                                        <button 
                                        class="actionButton updateButton"
                                        onclick='openModal(event, "offre", <?= json_encode([$offre, $offre->getID()]) ?>)'
                                        >
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

    </aside>

    <aside class="rightPart">
        <article class="container">

        </article>
    </aside>

</div>


<!-----  Emplacement de modal modification  -------->

<!---- MODAL modification offre ------>

<div class="modalContainer hiddenModal" id="modalOffre">
    <div class="modalUpdateOffre">
        <div class="modalHead">
            <div class="modalTitle">
                Modifier un type d'ingrédient
            </div>
            <button class="closeModalButton" onclick="closeModalOffre()">
                &times;
            </button>
        </div>
        <div class="modalBody">
            <form action="" method="POST" class="updateOffreForm">
                <input type="hidden" id="ID_offre_update" name="ID_offre_update" value="">
                <div class="inputGroup">
                    <label for="offreNomUpdate" class="inputLabel">
                        <input type="text" class="inputItem" name="nom_offre_update" id="offreNomUpdate" value="" placeholder="Nom" required />
                        <span>Nom</span>
                    </label>
                </div>
                <div class="inputGroup">
                    <label for="tauxOffreUpdate" class="inputLabel">
                        <input type="text" class="inputItem" name="taux_offre_update" id="tauxOffreUpdate" value="" placeholder="% de l'offre" required />
                        <span>% de l'offre</span>
                    </label>
                </div>
                <div class="inputGroup">
                    <label for="date_debut_offre_update" class="inputLabel">
                        <input type="date" class="inputItem" name="date_debut_offre_update" id="date_debut_offre_update" value="" placeholder="Débute le :" required />
                        <span>Débute le :</span>
                    </label>
                </div>
                <div class="inputGroup">
                    <label for="date_fin_offre_update" class="inputLabel">
                        <input type="date" class="inputItem" name="date_fin_offre_update" id="date_fin_offre_update" value="" placeholder="Fin le :" required />
                        <span>Fin le :</span>
                    </label>
                </div>
                <button type="submit" class="addButton">
                    Modifier
                </button>
            </form>
        </div>
    </div>
</div>

<!---- MODAL modification offre ------>


<!----- END  Emplacement de modal modification  -------->

<script type="text/javascript" src="./assets/js/toastController.js"></script>
<script type="text/javascript" src="./assets/js/animation.js"></script>
<script type="text/javascript" src="./assets/js/controlModal.js"></script>