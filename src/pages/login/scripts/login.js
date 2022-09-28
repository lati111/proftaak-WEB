const loginFormErrorId = "loginError";
const toSrcPath = "../../";

async function login() {
    const form = document.getElementById("loginForm");
    const email = form.querySelector('[name="email"]').value;
    const password = form.querySelector('[name="password"]').value;

    errorReset(loginFormErrorId)

    if (email === null) {
        showError(loginFormErrorId, "Email must be filled in");
    } else if (password === null) {
        showError(loginFormErrorId, "Password must be filled in");
    } else {
        const result = await ajax(toSrcPath, "developerLogin", {"email": email, "password": password });
        console.log(result);
    }
}

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