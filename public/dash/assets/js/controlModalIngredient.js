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
        var typeInput = document.querySelector('#ingredientIdTypeUpdate')
        var targetButton = e.target
        var name = targetButton.getAttribute('data-nomingredient')
        var prix = targetButton.getAttribute('data-prixingredient')
        var dispo = targetButton.getAttribute('data-dispoingredient')
        var idType = targetButton.getAttribute('data-idtypeingredient')


        modalContainer.classList.remove('hiddenModal')
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
}