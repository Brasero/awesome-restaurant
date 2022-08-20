function switchForm(to){
    var firstPart = document.querySelector('.produitFormPart1')
    var secondPart = document.querySelector('.produitFormPart2')
    if(to == 'toLeft'){
        firstPart.setAttribute('style', 'transform: translateX(-100%)')
        secondPart.setAttribute('style', 'transform: translateX(-100%)')
    }else{
        firstPart.setAttribute('style', 'transform: translateX(0)')
        secondPart.setAttribute('style', 'transform: translateX(0)')
    }
        
}