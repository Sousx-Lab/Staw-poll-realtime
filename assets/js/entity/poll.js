const poll = {};

function set(data){
    Object.assign(poll, data);
}

function get(){
    if(poll){
        return poll;
    }
    null;
}

export default{
    set,
    get
}