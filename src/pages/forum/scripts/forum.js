const toSrcPath = "../../";
let perPage = 10;

let questionTotal;
let pageQuestionTotal;
let currQuestionPage = 1;
let currQuestions;

let currQuestion;
let pageAnswerTotal;
let currAnwerPage = 1;
let currAnswers;

async function init() {
    questionTotal = await ajax(toSrcPath, "getQuestionCount");
    setQuestionPage(1);
    setQuestionPageNav();
    document.querySelector("#anwswerSubmit").addEventListener("click", postAnswer, false);

    let array = [1, 2, 3];
    setInterval(() => {
        array.push(array.shift());
        rotate()
    }, 1);
}

async function openQuestion(questionID) {
    currQuestion = currQuestions[questionID];
    document.querySelector("#question").textContent = currQuestion["vraag"];
    document.querySelector("#questionID").value = questionID;

    document.querySelector("#mainBody").classList.add("hidden");
    document.querySelector("#questionBody").classList.remove("hidden");

    setAnswerPageNav();
    setAnswerPage(1)
}

function closeQuestion() {
    document.querySelector("#mainBody").classList.remove("hidden");
    document.querySelector("#questionBody").classList.add("hidden");
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
        row.setAttribute("onclick", "openQuestion(" + question["ID"] + ")");
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

async function setAnswerPage(pageNr) {
    if (pageNr === "+1") {
        if (currAnwerPage === pageQuestionTotal) {
            return;
        }
        currAnwerPage++;
    } else if (pageNr === "-1") {
        if (currAnwerPage === 1) {
            return;
        }
        currAnwerPage--;
    } else {
        currAnwerPage = pageNr;
    }

    document.querySelector("#bestAnswer").innerHTML = "";
    document.querySelector("#answerForum").innerHTML = "";
    currAnswers = [];
    const answers = await ajax(toSrcPath, "getAnswers", { "questionID": currQuestion["ID"], "offset": ((currAnwerPage * perPage) - perPage), "amount": perPage });
    const bestAnswer = await ajax(toSrcPath, "getBestAnswer", { "questionID": currQuestion["ID"] });

    if (Object.keys(bestAnswer).length > 0) {
        const row = generateAnswer(bestAnswer["ID"], bestAnswer["antwoord"], bestAnswer["votes"], bestAnswer["hasVoted"])
        document.querySelector("#bestAnswer").append(row)
    }

    answers.forEach(answer => {
        const row = generateAnswer(answer["ID"], answer["antwoord"], answer["votes"], answer["hasVoted"])
        document.querySelector("#answerForum").append(row)
    });
}

function setAnswerPageNav() {
    pageAnswerTotal = Math.ceil(currQuestion["answerCount"] / perPage);
    let buttonIndex = 1;
    for (let i = (currAnwerPage - 3); i < (currAnwerPage + 3); i++) {
        if (i < 1) { continue }
        const button = document.createElement("button");
        button.value = i;
        button.textContent = i;
        document.querySelector("#pageAnswerButton" + buttonIndex).innerHTML = "";
        document.querySelector("#pageAnswerButton" + buttonIndex).append(button);
        button.setAttribute("onclick", "setAnswerPage(" + i + ")");
        buttonIndex++
    }
    if (pageAnswerTotal < 7) {
        for (let i = (pageAnswerTotal + 1); i < 8; i++) {
            document.querySelector("#pageAnswerButton" + i).innerHTML = "";
        }
    } else {
        if (currAnwerPage > 4) {
            const button = document.createElement("button");
            button.value = 1;
            button.textContent = 1;

            document.querySelector("#pageAnswerButton1").innerHTML = "";
            document.querySelector("#pageAnswerButton1").append(button);

            document.querySelector("#pageAnswerButton2").innerHTML = "...";
        }

        if (currAnwerPage < (pageAnswerTotal - 3)) {
            const button = document.createElement("button");
            button.value = pageAnswerTotal;
            button.textContent = pageAnswerTotal;

            document.querySelector("#pageAnswerButton6").innerHTML = "...";

            document.querySelector("#pageAnswerButton7").innerHTML = "";
            document.querySelector("#pageAnswerButton7").append(button);
        }
    }

}

function generateAnswer(answerID, antwoord, votes, hasVoted) {
    const row = document.createElement("tr");
    row.classList.add("forumRow")
    row.id = "answer-" + answerID

    const antwoordElement = document.createElement("td");
    antwoordElement.textContent = antwoord;
    row.append(antwoordElement)

    const votesSection = document.createElement("td");
    const voteSpan = document.createElement("span"); voteSpan.textContent = votes; votesSection.append(voteSpan);
    const voteButton = document.createElement("button"); voteButton.textContent = "^"; votesSection.append(voteButton);
    voteButton.addEventListener("click", vote, false);
    if (hasVoted === true) { voteButton.classList.add("voted") }
    row.append(votesSection)

    return row
}

async function postAnswer(e) {
    e.preventDefault()
    const row = document.querySelector("#answerInput");
    const antwoord = row.querySelector("textarea").value;
    if (antwoord.length <= 5) {
        showError("errors", "Answer must be at least 6 characters long")
    } else {
        const response = await ajax(toSrcPath, "postAnswer", { "antwoord": antwoord, "questionID": currQuestion["ID"] });
        if (response === true) {
            const row = generateAnswer(currQuestion["ID"], antwoord, 0, false)
            document.querySelector("#answerForum").prepend(row)

            const answerCounterElement = document.querySelector("#question-" + currQuestion["ID"]).lastElementChild;
            answerCounterElement.textContent = "" + (parseInt(answerCounterElement.textContent) + 1)
        } else {
            showError("errors", response)
        }
    }

}

async function vote(e) {
    if (document.querySelector("#loggedIn").value === "false") {
        showError("errors", "You must be logged in to vote on an asnwer", 1000)
    } else {
        const element = e.target;
        const voteCount = element.previousElementSibling;
        if (element.classList.contains("voted")) {
            const response = await ajax(toSrcPath, "unvote", { "answerID": parseInt(element.closest("tr").id.split("-")[1]) });
            if (response !== true) {
                showError("errors", response, 1000)
            } else {
                voteCount.textContent = "" + (parseInt(voteCount.textContent) - 1)
            }
            element.classList.remove("voted")
        } else {
            const response = await ajax(toSrcPath, "vote", { "answerID": parseInt(element.closest("tr").id.split("-")[1]) });
            if (response !== true) {
                showError("errors", response, 1000)
            } else {
                voteCount.textContent = "" + (parseInt(voteCount.textContent) + 1)
            }
            element.classList.add("voted")
        }
    }

}