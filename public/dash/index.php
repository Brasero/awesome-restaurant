<?php


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Burger Compagny</title>
</head>
<body>
    
    <?php
    if(isset($_SESSION['user']) && $_SESSION['user']['ID_role'] == 2){

    } else {
        include('../../vue/dash/adminConnexion.php');
    }

    ?>

</body>
</html>