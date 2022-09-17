function togglePanier(){
    var panierContainer = document.querySelector('.panierContainer')
    var cardpanier = document.querySelector('.cardPanier')
    var panierToggle = document.querySelector('.panierToggle')
    panierContainer.classList.toggle('active')
    panierToggle.classList.toggle('active')
    cardpanier.classList.toggle('active')
}