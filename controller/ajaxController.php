<?php
require('../model/config/Database.php');
require('../model/villeModel.php');

$bdd = new Database('exemple_panier', 'root', '', 'localhost');

function getVillesByName(PDO $bdd, string $name){
    $data = getVillesByNameLike($bdd, $name);

    return $data;
}

function getVilleByCp(PDO $bdd, int $cp){
    $data = getVillesByCp($bdd, $cp);

    return $data;
}

function dispatch(PDO $bdd, string $action, $payload){
    switch($action){
        case 'getVillesByName':
            $villes = getVillesByName($bdd, $payload);
            foreach($villes as $ville){
                $postaux = explode('-', $ville['codePostal_ville']);
                if(sizeof($postaux) > 1){
                    foreach($postaux as $postal){
                        echo '<div class="propItem" onclick="clickVille(\''.$ville['nom_ville'].'\', '.$postal.')">
                    <span>
                        '.$ville['nom_ville'].'
                    </span>
                    <span>
                        ('.$postal.')
                    </span>
                </div>';
                    }
                }else{
                    echo '<div class="propItem" onclick="clickVille(\''.$ville['nom_ville'].'\', '.$ville['codePostal_ville'].')">
                    <span>
                        '.$ville['nom_ville'].'
                    </span>
                    <span>
                        ('.$ville['codePostal_ville'].')
                    </span>
                    </div>';
                }
            }

            break;

        case 'getVillesByCp':
            $villes = getVilleByCp($bdd, $payload);
            foreach($villes as $ville){
                $postaux = explode('-', $ville['codePostal_ville']);
                if(sizeof($postaux) > 1){
                    foreach($postaux as $postal){
                        echo '<div class="propItem" onclick="clickVille(\''.$ville['nom_ville'].'\', '.$postal.')">
                    <span>
                        '.$ville['nom_ville'].'
                    </span>
                    <span>
                        ('.$postal.')
                    </span>
                </div>';
                    }
                }else{
                    echo '<div class="propItem" onclick="clickVille(\''.$ville['nom_ville'].'\', '.$ville['codePostal_ville'].')">
                    <span>
                        '.$ville['nom_ville'].'
                    </span>
                    <span>
                        ('.$ville['codePostal_ville'].')
                    </span>
                    </div>';
                }
            }
            break;
    }
}

if(isset($_GET['action'], $_GET['payload'])){
    dispatch($bdd->connection, $_GET['action'], $_GET['payload']);
}
?>