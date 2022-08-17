
//Donne la class 'hidden' au element ayant la class success ou error
function setToastDisparition(){
    //Selection des éléments du dom si ils existe (l'élément ciblé est le message de retour envoyer par les controlleur php lors d'une action, exemple : ajout d'un produit)
    var elementSuccess = document.querySelector('.success');
    var elementError = document.querySelector('.error');

    if(elementSuccess != null){
        elementSuccess.classList.add('hidden')
        setTimeout(() => {elementSuccess.remove()}, 500)
    }

    if(elementError != null){
        elementError.classList.add('hidden')
        setTimeout(() => {elementError.remove()}, 500)
    }
}

//appel la fonction setToastDisparition au bout du temps indiqué !!! ATTENTION !!! En cas de modification du temps d'application, il faut modifier le temps durant lequel l'animation progress est definie en css
setTimeout(setToastDisparition, 5000);