import { Form } from './component/Form'
import { handleVote } from './services/handleVote'

const App = () => {
    
    if (document.getElementById('home')) {
        let items = document.getElementById('response-item')
        Form(items)
    }

    if(document.getElementById('vote') && window.location.pathname.includes("/vote/")){
        handleVote()
    }

}
App()
