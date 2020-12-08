
function set(key, obj){
    return window.localStorage.setItem(key, JSON.stringify(obj))
}

function get(key){
    return JSON.parse(window.localStorage.getItem(key))
}

export default{
    set,
    get
}