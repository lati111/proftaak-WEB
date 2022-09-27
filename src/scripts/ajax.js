async function ajax(rootpath, Function, Parameters = []) {
    let formData = new FormData();
    formData.append('function', Function);
    formData.append('parameters', JSON.stringify(Parameters));

    if (typeof variable !== 'undefined') {
        console.error("rootpath variable not found")
    }
    const ajaxPath = rootpath + "backend/ajax.php";
    let promise = await fetch(ajaxPath, {
        method: 'POST',
        body: formData,
        headers: {
            'Accept': 'application/json'
            }})
        .then((response)=>response.json())
        .then((responseJson)=>{return responseJson});
    return promise;
}
