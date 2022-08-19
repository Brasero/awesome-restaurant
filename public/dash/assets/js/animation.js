var titleContainer = document.querySelector('.ingredientTitle')
var titleTop = document.querySelector('.ingredientTitle .top')
var titleBottom = document.querySelector('.ingredientTitle .bottom')

window.onload = () => {
    titleTop.removeAttribute('style')
    setTimeout(() => {titleBottom.removeAttribute('style')}, 500)
}