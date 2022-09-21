async function registerDeveloper() {
    table = document.getElementById("registerTable");
    const name = document.querySelector('[name="name"]').value;
    const nickname = document.querySelector('[name="nickname"]'.value);
    const email = document.querySelector('[name="email"]'.value);
    const password1 = document.querySelector('[name="password1"]'.value);
    const password2 = document.querySelector('[name="password2"]'.value);

    let valid = true;
    if (nickname === undefined) {
        nickname = null;
    }

    if (name !== null && name !== "") {
        if (name.match(/\W+/g)) {
            showError("Your name may not include numbers or symbols");
            valid = false;
        }
    } 
    else {
        showError("Name is a required field");
        valid = false;
    }
    
    if (email !== null) {
        if (email.match(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/)) {
            showError("Your email may not format compliant");
            valid = false;
        }
    } 
    else {
        showError("Email is a required field");
        valid = false;
    }

    if (password1 !== null) {
        if (password1.length > 6) {
            showError("Password must be longer than 6 characters");
            valid = false;
        }
        else if (password1 !== password2) {
            showError("Passwords do not match");
        }
    }
    else {
        showError("Password is a required field");
        valid = false;
    }

    if (valid) {
        console.log(name, nickname, email, password);
        return true;
    } else {
        return false;
    }

}

function showError(errorMessage) {
    console.log(errorMessage)
}