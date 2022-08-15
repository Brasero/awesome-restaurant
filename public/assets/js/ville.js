
function getVilleByName(){
    var villeInput = document.querySelector('#adresseVille')
    var inputValue = villeInput.value
    if(inputValue.length > 2){
        var req = new XMLHttpRequest()
        var reqURL = '../controller/ajaxController.php?action=getVillesByName&payload='+inputValue

        req.open('GET', reqURL)
        req.send()

        req.onload = function (){
            var prop = document.querySelector('#villeProp')
            prop.setAttribute('style', 'display: block;')
            prop.innerHTML = req.response
        }

    }else{
        var prop = document.querySelector('#villeProp')
        prop.setAttribute('style', 'display: none;')
        prop.innerHTML = ''
    }
}

function getVilleByCp(){
    var inputCp = document.querySelector('#adresseCp')
    var cpValue = inputCp.value

    if(cpValue.length > 2){
        var req = new XMLHttpRequest()
        var reqURL = '../controller/ajaxController.php?action=getVillesByCp&payload='+cpValue

        req.open('GET', reqURL)
        req.send()

        req.onload = function(){
            var prop = document.querySelector('#cpProp')

            prop.innerHTML = req.response
            prop.setAttribute('style', 'display: block;')
        }
    }else{

    }


}

function clickVille(name, cp){
    var inputVille = document.querySelector('#adresseVille')
    var inputCp = document.querySelector('#adresseCp')
    var prop = document.querySelectorAll('.proposition')
    inputVille.value = name
    inputCp.value = cp
    prop.forEach((element) => {
        element.setAttribute('style', 'display: none;')
        element.innerHTML = '';
    })
}

function closeProp(){
    var nameInput = document.querySelector('#adresseVille')
    var cpInput = document.querySelector('#adresseCp')

    nameInput.value = ''
    cpInput.value = ''
    var prop = document.querySelectorAll('.proposition')
    prop.forEach((element) => {
        element.setAttribute('style', 'display: none;')
        element.innerHTML = '';
    })
}