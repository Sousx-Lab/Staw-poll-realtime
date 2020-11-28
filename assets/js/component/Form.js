
export const Form = (itemsGroup)=> {

    let inputProto = document.getElementById('prototype').dataset.input
    let labelProto = document.getElementById('prototype').dataset.label
    let itemId = 3
    let deleteButton = `<div class="input-group-append"><button type="button" class="btn btn-danger" name="remove_field">-</button></div>`;

    function buildInput(placeHolder = "Autres résponse") {
        let input = inputProto.replace('__name__', itemId)
            .replace('[__name__]', '[' + itemId + ']')
            .replace('/>', `placeholder= "${placeHolder}" />`)
            
        let label = labelProto.replace('__name__', itemId)
            .replace('Réponse :', 'Réponse : ' + itemId)


        let divFormGroup = document.createElement('div')
        divFormGroup.className = 'form-group row'
        divFormGroup.id = itemId
        let divCol = document.createElement('div')

        divCol.className = 'col-sm-6'
        divFormGroup.appendChild(divCol);

        divCol.insertAdjacentHTML('beforeend', label)

        let divInputGroup = document.createElement('div')
        divInputGroup.className = 'input-group'
        divInputGroup.insertAdjacentHTML('beforeend', input)
        divInputGroup.insertAdjacentHTML('beforeend', deleteButton);
        divCol.appendChild(divInputGroup)
        return divFormGroup;
    }

    function handleForm(itemsGroup) {
        document.addEventListener('click', function (e) {
            if (e.target.name === 'remove_field') {
                deleteInput(e)
            } else if (e.target.name === 'add_field') {
                addInput(itemsGroup)
            }
        })
    }

    function addInput(itemsGroup) {
        if (itemId <= 9) {
            itemId++
            itemsGroup.appendChild(buildInput());
        } else {
            window.alert('Vous ne pouvez pas ajoutez plus de ' + itemId + ' réponse');
        }
    }

    async function deleteInput(e) {
        await e.target.parentNode.parentNode.parentNode.parentNode.remove()
        itemId--
    }

    handleForm(itemsGroup)
    
}
