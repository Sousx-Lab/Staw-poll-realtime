import { mercureSubscriber} from '../services/mercure'
let totalVote = 0

export function resultVote(poll) {

    function getTotalVote(){
        totalVote = 0
        poll.pollResponse.forEach(e => {
            totalVote += parseInt(e.score, 10)
        })
    }
    
    function buildResult() {
        let vote = document.getElementById('vote')
        getTotalVote() 
        vote.insertAdjacentHTML('beforeend', `<h5 id="${poll.id}" class="text-center">Totale vote ${totalVote}</h5>`) 
        poll.pollResponse.forEach(e => {
            let score = Math.round(e.score * 100 / totalVote)
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
        getTotalVote()
        document.getElementById(poll.id).innerText = `Totale vote ${totalVote}`
        poll.pollResponse.forEach(e => {
            let score = Math.round(e.score * 100 / totalVote)
            let divId = document.getElementById(e.id)
            divId.style.width = score + "%"
            divId.setAttribute('aria-valuenow', score)
            divId.innerText = score + "%"
        })

    }

    buildResult()
    mercureSubscriber(poll.id, updateView)

}