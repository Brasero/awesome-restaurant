function supprItem(type, idItem){
    var req = new XMLHttpRequest()
   
    if(type == 'typeIngredient'){
        var elementToSuppr = document.querySelector('#type-'+idItem);

        req.open('GET', '../../controller/dash/ajaxController.php?action=supprType&payload='+idItem)
        
    }else if(type == 'categorie') {
        var elementToSuppr = document.querySelector('#categorie-'+idItem);

        req.open('GET', '../../controller/dash/ajaxController.php?action=supprCategorie&payload='+idItem)
        
    }    
    else if(type == 'ingredient'){
        var elementToSuppr = document.querySelector('#ingredient-'+idItem);
        req.open('GET', '../../controller/dash/ajaxController.php?action=supprIngredient&payload='+idItem)
        
    }
     else if(type == 'taxe'){
        var elementToSuppr = document.querySelector('#taxe-'+idItem);
        req.open('GET', '../../controller/dash/ajaxController.php?action=supprTaxe&payload='+idItem)
        
    }
    
    req.send()

    req.onload = () => {
        
        if(req.response == true){
            elementToSuppr.remove()
            document.querySelector('.container').innerHTML += "<span class='success'><span class='message'>Supprimé avec succées</span><span class='progressBar'></span></span>";
            setTimeout(setToastDisparition, 5000)
        } else {
            document.querySelector('.container').innerHTML += "<span class='error'><span class='message'>Une erreur s'est produite, réessayez.</span><span class='progressBar'></span></span>"
            setTimeout(setToastDisparition, 5000)
        }
    }
    
}