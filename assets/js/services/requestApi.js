
/**
 * @param {String} url 
 * @param {FormData} formData 
 * @param {(String|number)} id
 * @returns {String} 
 */
async function post(url, id, formData)
{
    return fetch(url + id , {
        method: "POST",
        body: formData
    }).then(response => {
        if(!response.ok){
            throw new Error(response.statusText)
        }
        return response.json();
    })

}

async function get(url, id)
{
    return fetch(url, id, {
        method: "GET"
    }).then(response => {
        if(!response.ok){
            throw new Error(response.statusText)
        }
        return response.json();
    })
}

export default{
    post,
    get
}


