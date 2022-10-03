const toSrcPath = "../../";

async function init() {
    console.log(await ajax(toSrcPath, "getQuestionCount"))
}