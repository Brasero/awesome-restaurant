
function supprItem(type, idItem)
{
    let elementToSuppr;
    let req = new XMLHttpRequest();

    switch (type) {
        case 'typeIngredient':
            elementToSuppr = document.querySelector('#type-' + idItem);

            req.open('GET', '/ajax/type/delete/' + idItem)
            break;
        case 'categorie':
            elementToSuppr = document.querySelector('#categorie-' + idItem);

            req.open('GET', '/ajax/category/delete/' + idItem + '/aed2548sqsa214dcq-gdfsd56q')
            break;
        case 'ingredient':
            elementToSuppr = document.querySelector('#ingredient-' + idItem);
            req.open('GET', '/ajax/ingredient/delete/' + idItem)
            break;
        case 'taxe':
            elementToSuppr = document.querySelector('#taxe-' + idItem);
            req.open('GET', '/ajax/Taxe/delete/' + idItem)
            break;
        case 'user':
            elementToSuppr = document.querySelector('#user-' + idItem);
            req.open('GET', "/ajax/user/delete/" + idItem)
            break;
    }

    req.send()

    req.onload = () => {
        
        if (req.response === "true") {
            elementToSuppr.remove()
            document.querySelector('.toastContainer').innerHTML += "<span class='success'><span class='message'>Supprimé avec succées</span><span class='progressBar'></span></span>";
            setTimeout(setToastDisparition, 5000)
        } else {
            document.querySelector('.toastContainer').innerHTML += "<span class='error'><span class='message'>Une erreur s'est produite, réessayez.</span><span class='progressBar'></span></span>"
            setTimeout(setToastDisparition, 5000)
        }
    }
    
}