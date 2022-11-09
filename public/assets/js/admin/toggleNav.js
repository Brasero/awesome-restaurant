function toggleNav(){
    var navBarContainer = document.querySelector('.navBar')
    var navBar = document.querySelector('.navLinks')
    var toggleButton = document.querySelector('.toggleButton')

    navBarContainer.classList.toggle('active')
    navBar.classList.toggle('active')
    toggleButton.classList.toggle('active')
}

// let hamburger = document.querySelector('.navBurger');
// let navBar = document.querySelector('.navBar');
// let navLinks = document.querySelector('.navLinks');

// hamburger.addEventListener('click', () => {
//     navBar.classList.toggle("active");
//     navLinks.classList.toggle("active");
// })
