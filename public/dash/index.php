<?php

session_start();
require_once('../../model/config/Database.php');

$bdd = new Database('exemple_panier', 'root', '', 'localhost');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/ingredient.css">
    <link rel="stylesheet" href="./assets/css/produit.css">
    <link rel="stylesheet" href="./assets/css/formulaire.css">
    <link rel="stylesheet" href="./assets/css/toast.css">
    <link rel="stylesheet" href="./assets/css/modalIngredient.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <title>Burger Compagny</title>
</head>

<body>

    <?php
    if (isset($_SESSION['admin']) && $_SESSION['admin']['ID_role'] == 2 && $_SESSION['admin']['credentials'] == true) {
    ?>

        <div class="main">
            <nav class="navBar active">
                <ul class="navLinks active">
                    <div class="toggleButton active" onclick="toggleNav()">
                        <div class="top"></div>
                        <div class="bottom"></div>
                    </div>
                    <div class="brand">
                        <h1>Burger Compagny</h1>
                    </div>
                    <a href="index.php?page=dashboard" class="navLink 
                            <?= isset($_GET['page']) ?
                                ($_GET['page'] == 'dashboard' ? 'active' : '')
                                :
                                'active' ?>
                        ">
                        <li>
                            <i class="bi bi-speedometer2"></i>
                            <span>Dashboard</span>
                        </li>
                    </a>
                    <a href="index.php?page=clients" class="navLink
                        <?= (isset($_GET['page']) && $_GET['page'] == 'clients') ? 'active' : '' ?> ">
                        <li>
                            <i class="bi bi-person-circle">
                            </i>
                            <span>Clients</span>
                        </li>
                    </a>
                    <a href="index.php?page=produits" class="navLink
                        <?= (isset($_GET['page']) && $_GET['page'] == 'produits') ? 'active' : '' ?>">
                        <li><i><img src="https://img.icons8.com/cotton/64/000000/junk-food--v2.png" /></i><span>Produits</span></li>
                    </a>
                    <a href="index.php?page=ingredient" class="navLink
                        <?= (isset($_GET['page']) && $_GET['page'] == 'ingredient') ? 'active' : '' ?>">
                        <li>
                            <i>
                                <img src="https://img.icons8.com/color/48/000000/lettuce.png" />
                            </i>
                            <span>
                                Ingrédients
                            </span>
                        </li>
                    </a>
                    <a href="index.php?page=stats" class="navLink
                        <?= (isset($_GET['page']) && $_GET['page'] == 'stats') ? 'active' : '' ?>">
                        <li>
                            <i class="bi bi-graph-up"></i>
                            <span>
                                Statistiques
                            </span>
                        </li>
                    </a>
                    <a href="../../controller/deconnexionController.php" class="navLink deconnect">
                        <li>
                            <i class="bi bi-box-arrow-left"></i>
                            <span>Déconnexion</span>
                        </li>
                    </a>
                </ul>
            </nav>
            <div class="container">
                <?php

                if (isset($_GET['page'])) {
                    switch ($_GET['page']) {
                        case 'ingredient':
                            include('../../vue/dash/ingredient.php');
                            break;
                        case 'produits':
                            include('../../vue/dash/produit.php');
                            break;
                    }
                } else {
                    include('');
                }


                ?>
            </div>
        </div>

        <footer class="footer">

        </footer>


    <?php
    } else {
        include('../../vue/dash/adminConnexion.php');
    }

    ?>

    <script type="text/javascript" src="./assets/js/toggleNav.js"></script>

</body>

</html>