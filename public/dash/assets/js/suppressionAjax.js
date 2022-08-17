function supprItem(type, idItem){
    if(type == 'typeIngredient'){
        var elementToSuppr = document.querySelector('#type-'+idItem);

        var req = new XMLHttpRequest()

        req.open('GET', '../../controller/dash/ajaxController.php?action=supprType&payload='+idItem)
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
}