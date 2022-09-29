<?php

use Model\Config\Database;

require "../vendor/autoload.php";
session_start();
require('../model/config/Database.php');
$bdd = Database::getInstance('exemple_panier', 'root', '', 'localhost');

// function autoload($class){
//   if(file_exists('./../model/'.$class.'.php')){
//       require_once("../../model/dash/$class.php");
//   }
//   elseif(file_exists("./../controller/$class.php")){
//       require_once("./../controller/$class.php");
//   }
// }

// spl_autoload_register('autoload');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets/icon/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="./assets/css/style.css">
  <link rel="stylesheet" href="./assets/css/navBar.css">
  <script src="https://code.iconify.design/iconify-icon/1.0.0/iconify-icon.min.js"></script>
  
  <?php
    if (isset($_GET['page'])) {
        switch ($_GET['page']) {
            case 'login':
                echo '<link rel="stylesheet" href="./assets/css/formulaire.css">
            <link rel="stylesheet" href="./assets/css/connexion.css">';
                break;

            case 'signin':
                echo '<link rel="stylesheet" href="./assets/css/formulaire.css">
            <link rel="stylesheet" href="./assets/css/inscription.css">';
                break;
          
            case 'carte':
                echo '<link rel="stylesheet" href="./assets/css/carte.css">';
                break;

            case 'panier':
                echo '<link rel="stylesheet" href="./assets/css/panier.css">';
                break;
          
            default:
                echo '<link rel="stylesheet" href="./assets/css/carte.css">';
        }
    } else {
        echo '<link rel="stylesheet" href="./assets/css/carte.css">';
    }

    ?>
  <title>Burger Compagny</title>
</head>
<body>

  <header class="navContainer">
    <nav class="navBar">
      <button class="toggleButton" role="button" onclick="toggleNav()">
        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="25" fill="currentColor" class="bi bi-list" viewBox="0 0 35 16">
          <path fill-rule="evenodd" d="M20 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
        </svg>
      </button>
      <div class="brand">
        Burger compagny
      </div>
      <ul class="linkList">
      <?php
        if (isset($_SESSION['user'])) {
            ?>
        <li class="navItem" style="--i: 0;">
          <a href="../controller/deconnexionController.php" class="navHref">
            Déconnnexion
          </a>
        </li>
            <?php
        } else {
            ?>
          <li class="navItem <?= isset($_GET['page']) && $_GET['page'] == 'login' ? 'active' : '' ?>"  style="--i: 0;">
            <a href="index.php?page=login" class="navHref">
              Connexion
            </a>
          </li>
          <li class="navItem <?= isset($_GET['page']) && $_GET['page'] == 'signin' ? 'active' : '' ?>"  style="--i: 1;">
            <a href="index.php?page=signin" class="navHref">
              Inscription
            </a>
          </li>
            <?php
        }
        ?>
        <li class="navItem <?= isset($_GET['page']) && $_GET['page'] == 'carte' ? 'active' : (!isset($_GET['page']) ? 'active' : '') ?>" style="--i: 2;">
          <a href="index.php?page=carte" class="navHref">
            Carte
          </a>
        </li>
        <li class="navItem <?= isset($_GET['page']) && $_GET['page'] == 'panier' ? 'active' : '' ?>" style="--i: 3;">
          <a href="index.php?page=panier" class="navHref">
            Panier
          </a>
        </li>
      </ul>
    </nav>
  </header>

  <div class="container">
    <?php
    if (isset($_GET['page'])) {
        switch ($_GET['page']) {
            case 'login':
                include('../vue/connexion.php');
                break;

            case 'signin':
                include('../vue/inscription.php');
                break;
          
            case 'carte':
                include('../vue/carte.php');
                break;

            case 'panier':
                include('../vue/panier.php');
                break;
          
            default:
                include('../vue/carte.php');
        }
    } else {
        include('../vue/carte.php');
    }

    ?>
  </div>  

  <script src="./assets/js/onscrollFunction.js"></script>
  <script src="./assets/js/toggleNavBar.js"></script>
</body>
</html>
