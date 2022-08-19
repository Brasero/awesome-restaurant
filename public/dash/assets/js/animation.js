var titleContainer = document.querySelector('.pageTitle')
var titleTop = document.querySelector('.pageTitle .top')
var titleBottom = document.querySelector('.pageTitle .bottom')

window.onload = () => {
    titleTop.removeAttribute('style')
    setTimeout(() => {titleBottom.removeAttribute('style')}, 500)
}