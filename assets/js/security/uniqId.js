import {computeFingerprint} from "simple-fingerprint";

export function uniqId() {
    let id = generate()
    id.then((result) => {
        return result
    })
}

async function generate(){
    try {
       return await computeFingerprint()
        .then(id => {
           return id
        })
    } catch (error) {
        console.log(error)
    }
}