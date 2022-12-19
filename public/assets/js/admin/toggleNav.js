// nav version pc 
function toggleNav(){
    var navBarContainer = document.querySelector('.navBar')
    var navBar = document.querySelector('.navLinks')
    var toggleButton = document.querySelector('.toggleButton')

    navBarContainer.classList.toggle('active')
    navBar.classList.toggle('active')
    toggleButton.classList.toggle('active')
}

// responsive nav  
let hamburger = document.querySelector('.navBurger');
let navBar = document.querySelector('.navBar');
let navLinks = document.querySelector('.navLinks');
let closeNav = document.querySelector(".close");

hamburger.addEventListener('click', () => {
    navBar.classList.toggle("active");
    navLinks.classList.toggle("active");
    if(navBar.classList.contains("navBar")){
        closeNav.classList.add("active");
    }
    if(navBar.classList.contains("active")){
        closeNav.classList.remove("active");
    }
})
