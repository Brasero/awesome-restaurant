function supprItem(type, idItem){
    let elementToSuppr;
    let req = new XMLHttpRequest();

    switch (type) {
        case 'typeIngredient':
            elementToSuppr = document.querySelector('#type-' + idItem);

            req.open('GET', '/ajax/type/delete/' + idItem)
            break;
        case 'categorie':
            elementToSuppr = document.querySelector('#categorie-' + idItem);

            req.open('GET', '../../controller/dash/ajaxController.php?action=supprCategorie&payload=' + idItem)
            break;
        case 'ingredient':
            elementToSuppr = document.querySelector('#ingredient-' + idItem);
            req.open('GET', '/ajax/ingredient/delete/' + idItem)
            break;
        case 'taxe':
            elementToSuppr = document.querySelector('#taxe-' + idItem);
            req.open('GET', '../../controller/dash/ajaxController.php?action=supprTaxe&payload=' + idItem)
            break;
    }

    req.send()

    req.onload = () => {
        
        if (req.response === "true") {
            elementToSuppr.remove()
            document.querySelector('.container').innerHTML += "<span class='success'><span class='message'>Supprimé avec succées</span><span class='progressBar'></span></span>";
            setTimeout(setToastDisparition, 5000)
        } else {
            document.querySelector('.container').innerHTML += "<span class='error'><span class='message'>Une erreur s'est produite, réessayez.</span><span class='progressBar'></span></span>"
            setTimeout(setToastDisparition, 5000)
        }
    }
    
}