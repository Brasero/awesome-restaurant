function addFileText(event){
var image =document.querySelector('#image')
var inputVisible = document.querySelector('#fakeInput')
 if(image.value){
    var files = event.target.files
      for (const file of files) {
       inputVisible.innerHTML =file.name + ' a été choisie.'

  }
}
}