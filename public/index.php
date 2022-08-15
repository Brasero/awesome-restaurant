<?php
session_start();
require('../model/config/Database.php');
$bdd = new Database('exemple_panier', 'root', '', 'localhost');

var_dump($_SESSION);
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

  <header class="navContainer">
    <nav class="navBar">
      <div class="brand">
        Burger compagny
      </div>
      <ul class="linkList">
      <?php
        if(isset($_SESSION['user'])){
          ?>
        <li class="navItem">
          <a href="../controller/deconnexionController.php" class="navHref">
            Déconnnexion
          </a>
        </li>
          <?php
        } else {
          ?>
          <li class="navItem <?= isset($_GET['page']) && $_GET['page'] == 'login' ? 'active' : '' ?>">
            <a href="index.php?page=login" class="navHref">
              Connexion
            </a>
          </li>
          <li class="navItem <?= isset($_GET['page']) && $_GET['page'] == 'signin' ? 'active' : '' ?>">
            <a href="index.php?page=signin" class="navHref">
              Inscription
            </a>
          </li>
          <?php
        }
        ?>
        <li class="navItem <?= isset($_GET['page']) && $_GET['page'] == 'carte' ? 'active' : (!isset($_GET['page']) ? 'active' : '') ?>">
          <a href="index.php?page=carte" class="navHref">
            Carte
          </a>
        </li>
        <li class="navItem <?= isset($_GET['page']) && $_GET['page'] == 'panier' ? 'active' : '' ?>">
          <a href="index.php?page=panier" class="navHref">
            Panier
          </a>
        </li>
      </ul>
    </nav>
  </header>

  <div class="container">
    <?php
      if(isset($_GET['page'])){
        switch($_GET['page']){
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


</body>
</html>