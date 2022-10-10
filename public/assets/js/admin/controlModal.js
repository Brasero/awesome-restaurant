function openModal(e, action, id)
{
    let name;
    let targetButton;
    let idInput;
    let input;
    let modalContainer;
    if (action === 'type') {
        modalContainer = document.querySelector('#modalTypeIngredient');
        input = document.querySelector('#ingredientTypeNomUpdate');
        idInput = document.querySelector('#ingredientTypeIdUpdate');
        targetButton = e.target;
        name = targetButton.getAttribute('data-nomtype');
        if (name === null) {
            let icon = targetButton.querySelector('i');
            name = icon.getAttribute('data-nomtype');
        }

        modalContainer.classList.remove('hiddenModal')
        input.value = name
        idInput.value = id
    } else if (action === 'ingredient') {
        modalContainer = document.querySelector('#modalIngredient');
        idInput = document.querySelector('#ingredientIdUpdate');
        let nomInput = document.querySelector('#ingredientNomUpdate');
        let prixInput = document.querySelector('#ingredientPrixUpdate');
        let dispoInput = document.querySelector('#ingredientDispoUpdate');
        targetButton = e.target;
        name = targetButton.getAttribute('data-nomingredient');
        let prix = targetButton.getAttribute('data-prixingredient');
        let dispo = targetButton.getAttribute('data-dispoingredient');
        let idType = targetButton.getAttribute('data-idtypeingredient');
        let typeOption = document.querySelector('#ingredientTypeModifOption-' + idType);

        idInput.value = id
        nomInput.value = name
        prixInput.value = parseFloat(prix).toFixed(2)
        dispo === 1 ?
            dispoInput.setAttribute('checked', true)
             :
            dispoInput.removeAttribute('checked')
        typeOption.setAttribute('selected', true)
        modalContainer.classList.remove('hiddenModal')
    } else if (action === 'categorie') {
        modalContainer = document.querySelector('#modalCategorie');
        input = document.querySelector('#categorieNomUpdate');
        idInput = document.querySelector('#categorieIdUpdate');
        targetButton = e.target;
        name = targetButton.getAttribute('data-nomcategorie');

        modalContainer.classList.remove('hiddenModal')
        input.value = name
        idInput.value = id
    } else if (action === 'offre') {
        modalContainer = document.querySelector('.modalContainer');
        let offreID = id[1];
        let offreObj = id[0];
        let IDinput = document.querySelector('#ID_offre_update');
        let NomInput = document.querySelector('#offreNomUpdate');
        let pourcentInput = document.querySelector('#tauxOffreUpdate');
        let debutInput = document.querySelector('#date_debut_offre_update');
        let finInput = document.querySelector('#date_fin_offre_update');

        modalContainer.classList.remove('hiddenModal')
        IDinput.value = offreID
        NomInput.value = offreObj.nom
        pourcentInput.value = offreObj.taux * 100
        debutInput.value = offreObj.date_debut
        finInput.value = offreObj.date_fin
    } else if (action === 'taxe') {
        modalContainer = document.querySelector('#modalTaxe');
        input = document.querySelector('#taxeTauxUpdate');
        idInput = document.querySelector('#taxeIdUpdate');
        targetButton = e.target;
        var tauxTaxe = targetButton.getAttribute('data-tauxTaxe')
        console.log(tauxTaxe)
        modalContainer.classList.remove('hiddenModal')
        input.value = tauxTaxe
        idInput.value = id
    }
}

function closeModalType()
{
    let modalContainer = document.querySelector('.modalContainer');
    let input = document.querySelector('#ingredientTypeNomUpdate');
    let idInput = document.querySelector('#ingredientTypeIdUpdate');
    modalContainer.classList.add('hiddenModal');
    idInput.value = "";
    input.value = "";
}

function closeModalIngredient()
{
    let modalContainer = document.querySelector('#modalIngredient');
    modalContainer.classList.add('hiddenModal')
    let optionArray = document.querySelectorAll('#ingredientTypeModif option');
    optionArray.forEach(option => {
        option.removeAttribute('selected')
    })}

    function closeModalCategorie()
    {
        let modalContainer = document.querySelector('.modalContainer');
        let input = document.querySelector('#categorieNomUptade');
        let idInput = document.querySelector('#categorieIDUpdate');

        modalContainer.classList.add('hiddenModal');
        idInput.value = "";
        input.value = "";
    }


    function closeModalOffre()
    {
        let modalContainer = document.querySelector('.modalContainer');

        let IDinput = document.querySelector('#ID_offre_update');
        let NomInput = document.querySelector('#offreNomUpdate');
        let pourcentInput = document.querySelector('#tauxOffreUpdate');
        let debutInput = document.querySelector('#date_debut_offre_update');
        let finInput = document.querySelector('#date_fin_offre_update');

        IDinput.value = ""
        NomInput.value = ""
        pourcentInput.value = ""
        debutInput.value = ""
        finInput.value = ""

        modalContainer.classList.add('hiddenModal');
    }
    function closeModalTaxe()
    {
        let modalContainer = document.querySelector('#modalTaxe');
        let input = document.querySelector('#taxeIdUptade');
        let idInput = document.querySelector('#taxetauxUpdate');

        modalContainer.classList.add('hiddenModal');
        idInput.value = "";
        input.value = "";

    }