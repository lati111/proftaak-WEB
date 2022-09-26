const registerFormErrorId = "regTableError";

async function registerDeveloper() {
    table = document.getElementById("registerTable");
    const name = document.querySelector('[name="name"]').value;
    const nickname = document.querySelector('[name="username"]').value;
    const email = document.querySelector('[name="email"]').value;
    const password1 = document.querySelector('[name="password1"]').value;
    const password2 = document.querySelector('[name="password2"]').value;

    errorReset(registerFormErrorId)

    let valid = true;
    if (nickname === undefined || nickname === "") {
        nickname = null;
    }

    if (name !== null && name !== "") {
        if (!name.match(/^[a-zA-Z ]+$/)) {
            showError(registerFormErrorId, "Your name may not include numbers or symbols");
            valid = false;
        }
    }
    else {
        showError(registerFormErrorId, "Name is a required field");
        valid = false;
    }

    if (email !== null) {
        if (!email.match("^[a-zA-Z0-9.!#$%&\\'*+\\/=?^_\\`\\{|\\}~]+@[a-zA-Z0-9-]+(?:\\.[a-zA-Z0-9-]+)*$")) {
            showError(registerFormErrorId, "Your email must be format compliant");
            valid = false;
        }
    }
    else {
        showError(registerFormErrorId, "Email is a required field");
        valid = false;
    }

    if (password1 !== null) {
        if (password1.length < 6) {
            showError(registerFormErrorId, "Password must be 6 characters or longer");
            valid = false;
        }
        else if (password1 !== password2) {
            showError(registerFormErrorId, "Passwords do not match");
        }
    }
    else {
        showError(registerFormErrorId, "Password is a required field");
        valid = false;
    }

    if (valid) {
        const result = await ajax("registerDeveloper", {"nickname": nickname, "name": name, "email": email, "password": password1});
        return true;
    } else {
        return false;
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