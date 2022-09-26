async function ajax(Function, Parameters = []) {
    let formData = new FormData();
    formData.append('function', Function);
    formData.append('parameters', JSON.stringify(Parameters));

    const ajaxPath = "/src/backend/ajax.php"
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
