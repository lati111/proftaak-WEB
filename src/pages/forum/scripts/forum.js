const toSrcPath = "../../";
let questionTotal;
let perPage = 10;
let currPage = 2;

async function init() {
    questionTotal = await ajax(toSrcPath, "getQuestionCount");
    const questions = await ajax(toSrcPath, "getQuestions", {"offset": ((currPage * perPage) - perPage), "amount": perPage});
    console.log(questions);
}