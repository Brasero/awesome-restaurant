var navBarElement = document.querySelector('.navContainer');

window.onscroll = function(){
    console.log(window.scrollY);
    if(window.scrollY == 0) {
        navBarElement.removeAttribute('style');
    }
    else {
        if(navBarElement.getAttribute('style') == null){
            navBarElement.setAttribute('style', 'background: rgba(0,0,0,0.8);');
        }
    }
}