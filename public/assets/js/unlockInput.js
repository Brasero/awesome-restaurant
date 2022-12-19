function unlockInput(event){
    var inputElement = event.target.parentNode.parentNode.querySelector('input');
    console.log(inputElement);
    inputElement.removeAttribute('disabled');
    inputElement.focus();
    inputElement.select();
    inputElement.addEventListener('blur', lockInput);
}