<?php

function persoIsset($object){
    if(!empty($object)){
        foreach($object as $index => $value){
            if(!isset($object[$index]) || (empty($object[$index]) && $index != 'adresseComplement') ){
                return false;
            }
        }
    
        return true;
    } else {
        return false;
    }
}

?>