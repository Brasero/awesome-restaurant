// var navBarElement = document.querySelector('.navBar');
// var navBarElementUser = document.querySelector('.navAdresse');

// function toggleNav() {
//     navBarElement.classList.toggle('expanded');
// }
function toggleNav(event) {
    const parent = event.target.parentNode;
    var navBarElement = parent.parentNode;
    navBarElement.classList.toggle('expanded');

}