function checkPrice(e){
    var keyCode = e.which ? e.which : e.keyCode
    var touche = String.fromCharCode(keyCode)

    var input = e.target

    if(input.value.length == 0){ 
        var allowed = '0123456789';
    } else {  
        var allowed = '0123456789,.';
    }

    if(allowed.indexOf(touche) >= 0){
        input.value += touche
    }
}