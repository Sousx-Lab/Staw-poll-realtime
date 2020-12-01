import { postVote } from './postVoteApi'
import poll from '../entity/poll'

export function handleFormVote() {

    let formElem = document.querySelector('form')
    let pollId = formElem.id
    formElem.onsubmit = async function(e) {
        e.preventDefault()
        let formData = new FormData(formElem)
        try {
            await postVote(formData, pollId)
            .then((response) => {
                poll.set(response)
            })
        } catch (error) {
            console.log(error)
        }

    }
}