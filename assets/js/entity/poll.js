
export const poll = {
    id: "",
    title: "",
    createdAt: "",
    pollResponse: [],
    totalVote : function(){
        let acc = 0
        this.pollResponse.forEach(e => {
            acc += parseInt(e.score, 10)
        });
        return acc
    }
};
