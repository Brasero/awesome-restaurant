function openModal(e, action, id){
    if(action == 'type'){
        var modalContainer = document.querySelector('#modalTypeIngredient');
        var input = document.querySelector('#ingredientTypeNomUpdate');
        var idInput = document.querySelector('#ingredientTypeIdUpdate');
        var targetButton = e.target;
        var name = targetButton.getAttribute('data-nomtype')

        modalContainer.classList.remove('hiddenModal')
        input.value = name
        idInput.value = id
    }
    else if(action == 'ingredient'){
        var modalContainer = document.querySelector('#modalIngredient')
        var idInput = document.querySelector('#ingredientIdUpdate')
        var nomInput = document.querySelector('#ingredientNomUpdate')
        var prixInput = document.querySelector('#ingredientPrixUpdate')
        var dispoInput = document.querySelector('#ingredientDispoUpdate')
        var targetButton = e.target
        var name = targetButton.getAttribute('data-nomingredient')
        var prix = targetButton.getAttribute('data-prixingredient')
        var dispo = targetButton.getAttribute('data-dispoingredient')
        var idType = targetButton.getAttribute('data-idtypeingredient')
        var typeOption = document.querySelector('#ingredientTypeModifOption-'+idType)

        idInput.value = id
        nomInput.value = name
        prixInput.value = parseFloat(prix).toFixed(2)
        dispo == 1 ? 
            dispoInput.setAttribute('checked', true)
             : 
            dispoInput.removeAttribute('checked')
        typeOption.setAttribute('selected', true)
        modalContainer.classList.remove('hiddenModal')
    }
    else if(action == 'categorie'){
        var modalContainer = document.querySelector('.modalContainer');
        var input = document.querySelector('#categorieNomUpdate');
        var idInput = document.querySelector('#categorieIdUpdate');
        var targetButton = e.target;
        var name = targetButton.getAttribute('data-nomcategorie')

        modalContainer.classList.remove('hiddenModal')
        input.value = name
        idInput.value = id
    }
}

function closeModalType(){
    var modalContainer = document.querySelector('.modalContainer');
    var input = document.querySelector('#ingredientTypeNomUpdate');
    var idInput = document.querySelector('#ingredientTypeIdUpdate');
    modalContainer.classList.add('hiddenModal');
    idInput.value = "";
    input.value = "";
}

function closeModalIngredient(){
    var modalContainer = document.querySelector('#modalIngredient')
    modalContainer.classList.add('hiddenModal')
    var optionArray = document.querySelectorAll('#ingredientTypeModif option')
    optionArray.forEach(option => {
        option.removeAttribute('selected')
    })}

function closeModalCategorie(){
    var modalContainer = document.querySelector('.modalContainer');
    var input = document.querySelector('#categorieNomUptade')
    var idInput = document.querySelector('#categorieIDUpdate');

    modalContainer.classList.add('hiddenModal');
    idInput.value = "";
    input.value = "";
}