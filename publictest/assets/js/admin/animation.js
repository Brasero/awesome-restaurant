var titleContainer = document.querySelector('.pageTitle')
var titleTop = document.querySelector('.pageTitle .top')
var titleBottom = document.querySelector('.pageTitle .bottom')
var dashName = document.querySelector('.pageTitle .message');

window.onload = () => {
    titleTop.removeAttribute('style')
    setTimeout(() => {titleBottom.removeAttribute('style')}, 500)
    setTimeout(() => {dashName.setAttribute('style', 'opacity: 1;')}, 1000)
    
}