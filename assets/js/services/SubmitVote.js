
export function SubmitVote(){

    addEventListener('submit', function(e){
        e.preventDefault()
        let form = document.querySelector('form')
        let formData = new FormData(form)
        console.log(formData.get('poll_responses'));
       
    })
    

}