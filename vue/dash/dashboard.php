<?php



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
                <span class="col-row">
                    <div class="card__md"></div>
                </span>
                <span class="col-row">
                    <div class="card__md"></div>
                </span>
            </div>
            <div class="col-8">
                <div class="card__lg">
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
                                        name="pourcentage_offre" placeholder="pourcentage de l'offre"
                                        id="pourcentage_offre" 
                                        required />
                                    <span>% de l'offre</span>
                                </label>
                            </div>
                        </span>
                        <span class="part">
                            <label for="date_debut_offre" class="dateLabel">
                                Début de l'offre
                            </label>
                            <input type="date" name="date_debut_offre" id="date_debut_offre">
                        </span>
                        <span class="part">
                            <label for="date_fin_offre" class="dateLabel">
                                Fin de l'offre
                            </label>
                            <input type="date" name="date_fin_offre" id="date_fin_offre">
                        </span>
                        <span class="part">
                            <input type="submit" class="subButton" value="Ajouter">
                        </span>
                    </form>
                </div>
            </div>
        </section>
        <!-- END SECOND ROW CARD --->

        <section class="row">

        </section>

    </aside>

    <aside class="rightPart">
        <article class="container">

        </article>
    </aside>

</div>

<script type="text/javascript" src="./assets/js/animation.js"></script>