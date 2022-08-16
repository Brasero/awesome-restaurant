function checkPrice(e){
    //Récupération du code ASCII de la touche préssée
    var keyCode = e.which ? e.which : e.keyCode
    //Conversion du code ASCII en caractère conventionnel
    var touche = String.fromCharCode(keyCode)

    //récupération de l'input
    var input = e.target

    //si il s'agit du premier caractère tapez seul les chiffres sont autorisé, sinon la virgule et le point le sont aussi
    if(input.value.length == 0){ 
        var allowed = '0123456789';
    } else {  
        var allowed = '0123456789,.';
    }

    //Si la touche préssée correspond à un caractère autorisé il est ajouté dans le champs de saisie
    if(allowed.indexOf(touche) >= 0){
        input.value += touche
    }
}