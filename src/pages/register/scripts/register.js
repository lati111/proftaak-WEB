const registerFormErrorId = "regTableError";
const toSrcPath = "../../";

async function registerDeveloper() {
    const table = document.getElementById("registerTable");
    const name = table.querySelector('[name="name"]').value;
    const nickname = table.querySelector('[name="username"]').value;
    const email = table.querySelector('[name="email"]').value;
    const password1 = table.querySelector('[name="password1"]').value;
    const password2 = table.querySelector('[name="password2"]').value;

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
        const result = await ajax(toSrcPath, "registerDeveloper", { "nickname": nickname, "name": name, "email": email, "password": password1, "repeatPassword": password2});
        switch (result) {
            case true:
                document.querySelector("#registerSection").style.display = "none";
                document.querySelector("#registeredSection").style.display = "block";
                return true;
            case "E-23000":
                showError(registerFormErrorId, "An email address may only be used once");
                return false;
            default:
                return false;
        }
    } else {
        return false;
        showError("")
    }

}