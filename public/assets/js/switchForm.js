function switchForm(to){
    var firstPart = document.querySelector('.formSliderBlock.part1')
    var secondPart = document.querySelector('.formSliderBlock.part2')
    if(to == 'toLeft'){
        firstPart.setAttribute('style', 'transform: translateX(-110%)')
        secondPart.setAttribute('style', 'transform: translateX(0)')
    }else{
        firstPart.setAttribute('style', 'transform: translateX(0)')
        secondPart.setAttribute('style', 'transform: translateX(110%)')
    }
        
}