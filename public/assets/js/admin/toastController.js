
//Donne la class 'hidden' au element ayant la class success ou error
function setToastDisparition()
{
    //Selection des éléments du dom si ils existe (l'élément ciblé est le message de retour envoyer par les controlleur php lors d'une action, exemple : ajout d'un produit)
    const elementSuccess = document.querySelectorAll('.success');
    const elementError = document.querySelectorAll('.error');

    if (elementSuccess != null) {
        for (let element of elementSuccess) {
            element.classList.add('hidden');
            setTimeout(() => {element.remove()}, 500)
        }
    }

    if (elementError != null) {
        for (let element of elementError) {
            element.classList.add('hidden');
            setTimeout(() => {element.remove()}, 500)
        }
    }
}

//appel la fonction setToastDisparition au bout du temps indiqué !!! ATTENTION !!! En cas de modification du temps d'application, il faut modifier le temps durant lequel l'animation progress est definie en css
setTimeout(setToastDisparition, 5000);