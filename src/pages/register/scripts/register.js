async function registerDeveloper() {
    table = document.getElementById("registerTable");
    const name = document.querySelector('[name="name"]');
    const nickname = document.querySelector('[name="nickname"]');
    const email = document.querySelector('[name="email"]');
    const password = document.querySelector('[name="password"]');
    if (name.match(/\W+/g)) {
        showError("Your name may not include numbers or symbols")
    }
    if (nickname === undefined) {
        nickname = null;
    }
    if (email.match(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/)) {
        showError("Your email may not format compliant")
    }
    if (password.length > 6)){
        showError("Password must be longer than 6 characters")
    }

    

}

function showError(errorMessage) {
    console.log(errorMessage)
}