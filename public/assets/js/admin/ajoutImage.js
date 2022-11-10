function addFileText(event) {
    const parent = event.target.parentNode
    console.log()
    var image = event.target
    var inputVisible = parent.parentNode.parentElement.querySelector('.fakeInput')
    if (image.value) {
        var files = event.target.files
        for (var file of files) {
            inputVisible.innerHTML = file.name + ' a été choisie.'

        }
    }
}

function addFileTextupdate(event) {
    var image = document.querySelector('#imageupdate')
    var inputVisible = document.querySelector('#fakeInputupdate')
    if (image.value) {
        var files = event.target.files
        for (var file of files) {
            inputVisible.innerHTML = file.name + ' a été choisie.'

        }
    }
}