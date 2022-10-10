const toSrcPath = "../../";
let questionTotal;
let perPage = 10;
let currPage = 1;

async function init() {
    questionTotal = await ajax(toSrcPath, "getQuestionCount");
    const questions = await ajax(toSrcPath, "getQuestions", {"offset": ((currPage * perPage) - perPage), "amount": perPage});
    setPages();
    
}

function setPages() {
    const pageTotal = Math.ceil(questionTotal / perPage);
    let buttonIndex = 1;
        for(let i = (currPage - 3); i < (currPage + 3); i++) {
            const button = document.createElement("button");
            button.value = i;
            button.textContent = i;
            document.querySelector("#pageButton" + buttonIndex).innerHTML = "";
            document.querySelector("#pageButton" + buttonIndex).append(button);
            buttonIndex++
        }
        if (pageTotal < 7) {
            for (let i = (pageTotal + 1); i < 8; i++) {
                document.querySelector("#pageButton" + i).innerHTML = "";
            }
        } else {
            if (currPage > 4) {
                const button = document.createElement("button");
                button.value = 1;
                button.textContent = 1;

                document.querySelector("#pageButton1").innerHTML = "";
                document.querySelector("#pageButton1").append(button);

                document.querySelector("#pageButton2").innerHTML = "...";
            }

            if (currPage < (pageTotal - 3)) {
                const button = document.createElement("button");
                button.value = pageTotal;
                button.textContent = pageTotal;

                document.querySelector("#pageButton6").innerHTML = "...";

                document.querySelector("#pageButton7").innerHTML = "";
                document.querySelector("#pageButton7").append(button);
            }
        }
        
}