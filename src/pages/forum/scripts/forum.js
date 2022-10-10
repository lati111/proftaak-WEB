const toSrcPath = "../../";
let questionTotal;
let perPage = 10;
let currPage = 1;

async function init() {
    questionTotal = await ajax(toSrcPath, "getQuestionCount");
    const questions = await ajax(toSrcPath, "getQuestions", {"offset": ((currPage * perPage) - perPage), "amount": perPage});
    
}

function setPages() {
    const pageTotal = Math.ceil(questionTotal / perPage);
    if (pageTotal > 7) {
        const buttonEnd = document.createElement("button"); 
        buttonEnd.value = pageTotal;
        buttonEnd.textContent = pageTotal;
        document.querySelector("#pageButton7").innerHTML = "";
        document.querySelector("#pageButton7").append(buttonEnd);

        document.querySelector("#pageButton6").querySelector("button").innerHTML = "...";
    } else {
        const buttons = document.querySelector("#pageNav")
        for(let i = 1; i < (pageTotal + 1); i++) {
            const button = document.createElement("button");
            button.value = i;
            button.textContent = i;
            document.querySelector("#pageButton" + i).innerHTML = "";
            document.querySelector("#pageButton" + i).append(button);
        }
        for (let i = (pageTotal + 1); i < 8; i++) {
            const button = document.createElement("button");
            document.querySelector("#pageButton" + i).innerHTML = "";
        }
    }
}