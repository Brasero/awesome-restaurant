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
    <title>Burger Compagny</title>
</head>
<body>
    
    <?php
    if(isset($_SESSION['admin']) && $_SESSION['admin']['ID_role'] == 2 && $_SESSION['admin']['credentials'] == true){
        ?>

        <div class="main">
            <nav class="navBar">
                <div class="brand">
                    <h1>Burger Compagny</h1>
                </div>
                <ul class="navLinks">
                    <a href="index.php?page=dashboard" 
                        class="navLink 
                            <?= isset($_GET['page']) ? 
                                    ($_GET['page'] == 'dashboard' ? 'active' : '') 
                                    : 
                                    'active' ?>
                        " >
                        <li>Dashboard</li>
                    </a>
                    <a href="index.php?page=clients" 
                    class="navLink
                        <?= (isset($_GET['page']) && $_GET['page'] == 'clients') ? 'active' : '' ?> "
                    >
                        <li>Clients</li>
                    </a>
                    <a href="index.php?page=produits" 
                    class="navLink
                        <?= (isset($_GET['page']) && $_GET['page'] == 'produits') ? 'active' : '' ?>"
                    >
                        <li>Produits</li>
                    </a>
                    <a href="index.php?page=stats" 
                    class="navLink
                        <?= (isset($_GET['page']) && $_GET['page'] == 'stats') ? 'active' : '' ?>"
                    >
                        <li>Statistiques</li>
                    </a>
                    <a href="../../controller/deconnexionController.php" class="navLink deconnect"><li>Deconnexion</li></a>
                </ul>
            </nav>
            <div class="container">
                <h1>
                    Contenu
                </h1>
            </div>
        </div>

        <footer class="footer">

        </footer>


        <?php
    } else {
        include('../../vue/dash/adminConnexion.php');
    }

    ?>

</body>
</html>