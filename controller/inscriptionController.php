<?php


require_once('../model/AdresseModel.php');
require_once('../model/userModel.php');
require_once('../model/villeModel.php');
require_once('../controller/function.php');


function createNewUser(PDO $bdd, array $user){
    

    if(persoIsset($user)){
        if(filter_var($user['email'], FILTER_VALIDATE_EMAIL) && $user['email'] == $user['confirmEmail']){
            if($user['mdp'] == $user['confirmMdp']){
                $ID_ville = getVilleByNameAndCp($bdd, ['nom' => $user['adresseVille'], 'cp' => $user['adresseCp']]);

                $adresse = new AdresseModel(null, $user['adresseName'], $user['adressePrefix'], $user['adresseNumber'], $ID_ville['ID_ville']);

                $adresse->saveAdresse($bdd);

                //define password hash
                $pass = password_hash($user['mdp'], PASSWORD_BCRYPT);


                //define user to insert
                $userIns = array(
                    'nom'=> htmlspecialchars(strip_tags($user['nom'])), 
                    'mail'=> htmlspecialchars(strip_tags($user['email'])), 
                    'mdp'=> $pass, 
                    'prenom'=> htmlspecialchars(strip_tags($user['prenom'])),
                    'tel' => strip_tags(str_replace(' ', '', $user['tel'])), 
                    'role' => 1,
                    'adresse' => $adresse->getID_adresse()
                );

                //setUser in DB
                if(setUser($bdd, $userIns)) return
                    '<span class="success">Utilisateur crée.</span>';

            }
            else{
                return '<span class="error">Vos mots de passe ne correspondent pas</span>';
            }
        }else{
            return '<span class="error"> Merci de saisir un email valide</span>';
        }
    } else {
        return '<span class="error">Merci de compléter tout les champs obligatoire</span>';
    }

}


?>