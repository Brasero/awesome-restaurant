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
    var modalContainer = document.querySelector('#modalCategorie');
        var input = document.querySelector('#categorieNomUpdate');
        var idInput = document.querySelector('#categorieIdUpdate');
        var targetButton = e.target;
        var name = targetButton.getAttribute('data-nomcategorie')

        modalContainer.classList.remove('hiddenModal')
        input.value = name
        idInput.value = id
    }


    else if(action == 'offre') {
        var modalContainer = document.querySelector('.modalContainer')
        var offreID = id[1]
        var offreObj = id[0]
        var IDinput = document.querySelector('#ID_offre_update')
        var NomInput = document.querySelector('#offreNomUpdate')
        var pourcentInput = document.querySelector('#tauxOffreUpdate')
        var debutInput = document.querySelector('#date_debut_offre_update')
        var finInput = document.querySelector('#date_fin_offre_update')

        modalContainer.classList.remove('hiddenModal')
        IDinput.value = offreID
        NomInput.value = offreObj.nom
        pourcentInput.value = offreObj.taux * 100
        debutInput.value = offreObj.date_debut
        finInput.value = offreObj.date_fin
    }
     else if(action == 'taxe'){
        var modalContainer = document.querySelector('#modalTaxe');
        var input = document.querySelector('#taxeTauxUpdate');
        var idInput = document.querySelector('#taxeIdUpdate');        
        var targetButton = e.target;
        var tauxTaxe = targetButton.getAttribute('data-tauxTaxe')
console.log(tauxTaxe)
        modalContainer.classList.remove('hiddenModal')
        input.value = tauxTaxe
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


function closeModalOffre(){
    var modalContainer = document.querySelector('.modalContainer');

    var IDinput = document.querySelector('#ID_offre_update')
    var NomInput = document.querySelector('#offreNomUpdate')
    var pourcentInput = document.querySelector('#tauxOffreUpdate')
    var debutInput = document.querySelector('#date_debut_offre_update')
    var finInput = document.querySelector('#date_fin_offre_update')

    IDinput.value = ""
    NomInput.value = ""
    pourcentInput.value = ""
    debutInput.value = ""
    finInput.value = ""

    modalContainer.classList.add('hiddenModal');
}
function closeModalTaxe(){
    var modalContainer = document.querySelector('#modalTaxe');
    var input = document.querySelector('#taxeIdUptade')
    var idInput = document.querySelector('#taxetauxUpdate');

    modalContainer.classList.add('hiddenModal');
    idInput.value = "";
    input.value = "";

}