import requestApi from './requestApi'
import { poll } from '../entity/poll'
import { VOTE_URL } from './config'
import localStorage from '../persistance/localStorage'
import cookies from '../persistance/cookies'
import { progressBar } from '../component/progressBar'

export function handleVote() {
    
    let pollId = window.location.pathname.replace('/vote/', '')
    let formElem = document.getElementById(pollId)

    //Check if cookie or localstorage contains poll id
    if(null !== cookies.getCookie(pollId) || null !== localStorage.get(pollId)){
        poll.id = pollId
        poll.title = document.getElementById('poll_title').innerText
        document.getElementsByName('poll_responses').forEach((v) => {
            poll.pollResponse.push({id: v.id, content: v.dataset.content, score: v.dataset.score})
            
        })
        formElem.remove()
        progressBar(poll)
    }
    
    formElem.onsubmit = async function(e) {
        e.preventDefault()
        let formData = new FormData(formElem)
        try {
            await requestApi.post(VOTE_URL, pollId, formData)
            .then((response) => {
                Object.assign(poll, response)
                localStorage.set(pollId, formData.get('poll_responses'))
                cookies.setCookie(pollId, formData.get('poll_responses'), 5)
                formElem.remove()
                progressBar(poll)
            })
        } catch (error) {
            throw new Error(error)
        }

    }
}