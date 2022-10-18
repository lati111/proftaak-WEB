function showError(locationID, errorMessage, autoclearDuration = 0) {
    const errorElement = document.createElement("li");
    errorElement.classList.add("error")
    errorElement.textContent = errorMessage
    document.getElementById(locationID).append(errorElement);

    if (autoclearDuration !== 0) {
        setTimeout((errorElement) => {
            errorElement.remove();
        }, autoclearDuration);
    }
}

function errorReset(locationID) {
    document.getElementById(locationID).innerHTML = "";
}