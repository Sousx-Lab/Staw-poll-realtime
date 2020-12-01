import { VOTE_URL } from './config'

export async function postVote(formData, id)
{
    return fetch(VOTE_URL + id , {
        method: "POST",
        body: formData
    }).then(response => {
        if(!response.ok){
            throw Error(response.statusText)
        }
        return response.json();
    })

}

