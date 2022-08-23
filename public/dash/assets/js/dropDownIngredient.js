function toggleIngredientList(e, id){
    
    if(e.target.getAttribute('name') == null && !e.target.classList.contains('ingredientLabel')){
        var allOther = document.querySelectorAll('.typeIngredientGroupItem')

        allOther.forEach(list => {
            if(list.getAttribute('id') != 'type-'+id){
                list.classList.remove('expand')
                list.querySelector('i').classList.remove('bi-caret-up-fill')
                list.querySelector('i').classList.add('bi-caret-down-fill')
            }
        });

        var target = document.querySelector('#type-'+id)
        var arrowIcon = document.querySelector('#type-'+id+' .groupLabel i')

        if(arrowIcon.classList.contains('bi-caret-down-fill')){
            arrowIcon.classList.remove('bi-caret-down-fill')
            arrowIcon.classList.add('bi-caret-up-fill')
        }else{
            arrowIcon.classList.remove('bi-caret-up-fill')
            arrowIcon.classList.add('bi-caret-down-fill')
        }
        target.classList.toggle('expand')
    }
}