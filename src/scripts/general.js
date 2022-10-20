function showError(locationID, errorMessage, autoclearDuration = 0) {
    const errorElement = document.createElement("li");
    errorElement.classList.add("error")
    errorElement.textContent = errorMessage
    document.getElementById(locationID).prepend(errorElement);
    

    if (autoclearDuration !== 0) {
        errorElement.classList.add("tempError");
        setTimeout(() => {
            document.querySelector(".tempError").remove();
        }, autoclearDuration);
    }
}

function errorReset(locationID) {
    document.getElementById(locationID).innerHTML = "";
}

let currRotation = 0;
function rotate() {
    currRotation++;
    if (currRotation === 360) {
        currRotation = 1;
    }
    document.querySelector("#skullduggery").style.transform = "rotate(" + currRotation +"deg)"; 
}