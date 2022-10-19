function init2() {
    document.querySelector("#questionSubmit").addEventListener("click", postQuestion, false);
}

async function postQuestion(e) {
    e.preventDefault()
    const row = document.querySelector("#questionInput");
    const question = row.querySelector("textarea").value;
    if (question.length <= 5) {
        showError("errors", "Question must be at least 6 characters long")
    } else {
        const response = await ajax(toSrcPath, "postQuestion", {"question": question});
        if (response === true) {
            location.href = "http://localhost/proftaak-WEB/src/pages/forum/index.php"
        } else {
            showError("errors", response)
        }
    }

}