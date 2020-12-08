/**
 * 
 * @param {Object} poll 
 */
export function resultVote(poll) {
    let vote = document.getElementById('vote')
    let totalVote = 0
    poll.pollResponse.forEach(e =>{
        totalVote+= parseInt(e.score, 10)
    })
    
    poll.pollResponse.forEach(e => {
        let score = Math.round(e.score*100/totalVote)
        vote.insertAdjacentHTML("beforeend",
        `<div class="d-flex justify-content-center text-center">
           <div class="col-6 mt-3 mb-5">
            <strong>"${e.content}"</strong>
                 <div class="progress" style="height: 20px;">
              <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: ${score}%;" aria-valuenow="${score}" aria-valuemin="0" aria-valuemax="100">${score}%</div>
             </div>
          </div>
        </div>
        </div>
        `
    )});


}


