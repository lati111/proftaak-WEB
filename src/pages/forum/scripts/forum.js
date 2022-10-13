const toSrcPath = "../../";
let questionTotal;
let pageQuestionTotal
let perPage = 10;
let currQuestionPage = 1;
let currQuestions;

async function init() {
    questionTotal = await ajax(toSrcPath, "getQuestionCount");
    setQuestionPage(1);
    setQuestionPageNav();
}

async function openQuestion(questionID) {
    console.log(questionID);
}

async function setQuestionPage(pageNr) {
    if (pageNr === "+1") {
        if (currQuestionPage === pageQuestionTotal) {
            return;
        }
        currQuestionPage++;
    } else if (pageNr === "-1") {
        if (currQuestionPage === 1) {
            return;
        }
        currQuestionPage--;
    } else {
        currQuestionPage = pageNr;
    }

    document.querySelector("#forum").innerHTML = "";
    currQuestions = [];
    const questions = await ajax(toSrcPath, "getQuestions", { "offset": ((currQuestionPage * perPage) - perPage), "amount": perPage });
    questions.forEach(question => {
        currQuestions[question["ID"]] = question;
        const row = document.createElement("tr");
        row.setAttribute("onclick", "openQuestion("+question["ID"]+")");
        row.classList.add("forumRow")
        row.id = "question-" + question["ID"]

        const vraag = document.createElement("td");
        vraag.textContent = question["vraag"];
        row.append(vraag)

        const answers = document.createElement("td");
        answers.textContent = question["answerCount"];
        row.append(answers)

        document.querySelector("#forum").append(row)
    });
}

function setQuestionPageNav() {
    pageQuestionTotal = Math.ceil(questionTotal / perPage);
    let buttonIndex = 1;
    for (let i = (currQuestionPage - 3); i < (currQuestionPage + 3); i++) {
        if (i < 1) { continue }
        const button = document.createElement("button");
        button.value = i;
        button.textContent = i;
        document.querySelector("#pageQuestionButton" + buttonIndex).innerHTML = "";
        document.querySelector("#pageQuestionButton" + buttonIndex).append(button);
        button.setAttribute("onclick", "setQuestionPage(" + i + ")");
        buttonIndex++
    }
    if (pageQuestionTotal < 7) {
        for (let i = (pageQuestionTotal + 1); i < 8; i++) {
            document.querySelector("#pageQuestionButton" + i).innerHTML = "";
        }
    } else {
        if (currQuestionPage > 4) {
            const button = document.createElement("button");
            button.value = 1;
            button.textContent = 1;

            document.querySelector("#pageQuestionButton1").innerHTML = "";
            document.querySelector("#pageQuestionButton1").append(button);

            document.querySelector("#pageQuestionButton2").innerHTML = "...";
        }

        if (currQuestionPage < (pageQuestionTotal - 3)) {
            const button = document.createElement("button");
            button.value = pageQuestionTotal;
            button.textContent = pageQuestionTotal;

            document.querySelector("#pageQuestionButton6").innerHTML = "...";

            document.querySelector("#pageQuestionButton7").innerHTML = "";
            document.querySelector("#pageQuestionButton7").append(button);
        }
    }

}