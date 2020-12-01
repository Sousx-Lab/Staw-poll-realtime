import { Form } from './component/Form'
import { handleFormVote } from './services/handleFormVote'
import { uniqId } from './security/uniqId'

const App = () => {
    uniqId()  
    if (document.getElementById('home')) {
        let items = document.getElementById('response-item')
        Form(items)
    }

    if(document.getElementById('vote')){
        handleFormVote()
    }

}

App()