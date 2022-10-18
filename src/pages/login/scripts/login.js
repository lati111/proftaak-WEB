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
        if (result === true){
            window.location.href = "../forum";
        } else if (result !== false) {
            showError(loginFormErrorId, result); 
        }
    }
}