function toggleNav(){
    var navBarContainer = document.querySelector('.navBar')
    var navBar = document.querySelector('.navLinks')
    var toggleButton = document.querySelector('.toggleButton')

    navBarContainer.classList.toggle('active')
    navBar.classList.toggle('active')
    toggleButton.classList.toggle('active')
}

