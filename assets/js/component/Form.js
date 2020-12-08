
export function Form(itemsGroup){

    let inputProto = document.getElementById('prototype').dataset.input
    let labelProto = document.getElementById('prototype').dataset.label
    let itemsId = 3

    /**
     * 
     * @param {string} placeHolder 
     */
    function buildInput(placeHolder) {
        let input = inputProto.replace('__name__', itemsId)
            .replace('[__name__]', '[' + itemsId + ']')
            .replace('/>', `placeholder= "${placeHolder}" />`)
            
        let label = labelProto.replace('__name__', itemsId)
            .replace('Réponse :', 'Réponse : ' + itemsId)


        let divFormGroup = document.createElement('div')
        divFormGroup.className = 'form-group row'
        divFormGroup.id = itemsId
        let divCol = document.createElement('div')

        divCol.className = 'col-sm-6'
        divFormGroup.appendChild(divCol);

        divCol.insertAdjacentHTML('beforeend', label)

        let divInputGroup = document.createElement('div')
        divInputGroup.className = 'input-group'
        divInputGroup.insertAdjacentHTML('beforeend', input)
        divCol.appendChild(divInputGroup)
        return divFormGroup;
    }

    function addInput(itemsGroup) {
        if (itemsId <= 9) {
            itemsId++
            let placeholder = (itemsId === 1) ? "Matrix" :(itemsId === 2) ? "Matrix Reload" :(itemsId === 3) ? "Matrix Revolution" : "Autre responses"
            itemsGroup.appendChild(buildInput(placeholder));
        } else {
            window.alert('Vous ne pouvez pas ajoutez plus de ' + itemsId + ' réponse');
        }
    }

    function deleteInput(items) {
        if(itemsId > 0){
            itemsId--
            items.removeChild(items.lastElementChild)
        }
        
    }

    function handleForm(itemsGroup) {
        document.addEventListener('click', function (e) {
            if (e.target.name === 'remove_field') {
                deleteInput(itemsGroup)
            } else if (e.target.name === 'add_field') {
                addInput(itemsGroup)
            }
        })
    }

    handleForm(itemsGroup)
    
}
