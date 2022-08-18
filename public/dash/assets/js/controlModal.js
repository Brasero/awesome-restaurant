function openModal(e, action, id){
    if(action == 'type'){
        var modalContainer = document.querySelector('.modalContainer');
        var input = document.querySelector('#ingredientTypeNomUpdate');
        var idInput = document.querySelector('#ingredientTypeIdUpdate');
        var targetButton = e.target;
        var name = targetButton.getAttribute('data-nomtype')

        modalContainer.classList.remove('hiddenModal')
        input.value = name
        idInput.value = id
    }
    else if(action == 'categorie'){
        var modalContainer = document.querySelector('.modalContainer');
        var input = document.querySelector('#categorieNomUptade');
        var idInput = document.querySelector('#categorieIdUptade');
        var targetButton = e.target;
        var name = targetButton.getAttribute('data-nomcategorie')

        modalContainer.classList.remove('hiddenModal')
        input.value = name
        idInput.value = id
    }
}

function closeModal(){
    var modalContainer = document.querySelector('.modalContainer');
    var input = document.querySelector('#ingredientTypeNomUpdate');
    var idInput = document.querySelector('#ingredientTypeIdUpdate');
    modalContainer.classList.add('hiddenModal');
    idInput.value = "";
    input.value = "";
}

function closeModalCategorie(){
    var modalContainer = document.querySelector('.modalContainer');
    var input = document.querySelector('#categorieNomUptade')
    var idInput = document.querySelector('#categorieIDUpdate');

    modalContainer.classList.add('hiddenModal');
    idInput.value = "";
    input.value = "";
}