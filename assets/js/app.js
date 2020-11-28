import {
    Form
} from './component/Form'
import { SubmitVote } from './services/SubmitVote'

const App = () => {
    if (document.getElementById('home')) {
        let items = document.getElementById('response-item')
        Form(items)
    }

    if(document.getElementById('vote')){
        SubmitVote();
    }

}

App()