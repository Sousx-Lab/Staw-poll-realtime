import { mercureSubscriber} from '../services/mercure'

export function progressBar(poll) {
    
    function buildHtml() {
        let vote = document.getElementById('vote')
        vote.insertAdjacentHTML('beforeend', `<h5 id="${poll.id}" class="text-center">Totale vote ${poll.totalVote()}</h5>`)
        
        poll.pollResponse.forEach(e => {
            let score = Math.round(e.score * 100 / poll.totalVote())
            vote.insertAdjacentHTML('beforeend',
                `<div class="d-flex justify-content-center text-center mb-5">
                  <div class="col-6 mt-3">
                <strong>${e.content}</strong>
                    <div class="progress" style="height: 25px;">
                <div class="progress-bar progress-bar-striped bg-success" id="${e.id}" role="progressbar" style="width: ${score}%;" aria-valuenow="${score}" aria-valuemin="0" aria-valuemax="100">${score}%</div>
                </div>
            </div>
            </div>
            </div>
            `
        )});
    }

    /** 
     * @param {object} poll
     */
    function updateView(poll){
        document.getElementById(poll.id).innerText = `Totale vote ${poll.totalVote()}`
        
        poll.pollResponse.forEach(e => {
            let score = Math.round(e.score * 100 / poll.totalVote())
            let divId = document.getElementById(e.id)
            divId.style.width = score + "%"
            divId.setAttribute('aria-valuenow', score)
            divId.innerText = score + "%"
        })

    }
    buildHtml()
    mercureSubscriber(poll.id, updateView)

}