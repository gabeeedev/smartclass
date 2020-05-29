//
//Votes
//

function addNewVotingAnswer(e) {
    e.preventDefault();

    $("#votingAnswerList").append(`
        <div class='form-group col-12'>
            <input type='text' class='form-control' name='votingAnswer'>
        </div>`
    );
}
handler("click", "#votingAddNewAnswer", addNewVotingAnswer);

//
//Quiz bank
//

function addNewQuizQuestion(e) {
    type = $(this).attr("newQuizQuestion");

    var dom = "<div quiz-question type='" + type + "' class='block px-3 pt-3 mb-4'>";
    dom += "<div class='form-group'>";  
    dom += "<div class='d-flex'>"
    dom += "<label>Question</label>"
    dom += "<span class='badge badge-secondary ml-auto align-self-center px-2 py-1 mr-1'>" + $(this).html() + "</span>";
    dom += "</div>";
    dom += "<input type='text' class='form-control' name='questionTitle'></input>";
    dom += "</div>";

    switch (type) {
        case "choice":
        case "multichoice":
            dom += generateQuizChoiceQuestion();
            break;
    
        default:
            break;
    }
        
    // dom += "<div class='text-right'><small>" + $(this).html() + "</small></div>";
    dom += "</div>";
    $("#questionList").append(dom);

}
overwriteHandler("click","[newQuizQuestion]",addNewQuizQuestion);


function generateQuizChoiceQuestion() {
    var dom = "<div class='form-group'>";
    dom += "<label>Answers</label>";
    dom += "<div class='quiz-option-list'><input type='text' class='form-control my-1 quiz-option'></input></div>"
    dom += "<button class='btn btn-secondary quiz-option-adder mt-2'>Add option</button>";
    dom += "</div>";
    return dom;
}

function addQuizChoiceOption(e) {
    e.preventDefault();
    $(this).siblings(".quiz-option-list").append("<input type='text' class='form-control my-1 quiz-option'></input>");
}
overwriteHandler("click",".quiz-option-adder",addQuizChoiceOption);

//
//Content editor
//

function editorButtonHandler() {
    var editorType = $(this).attr("editorType");
    var editorCmd = $(this).attr("editorCmd");
    var editorAttr = $(this).attr("editorAttr");

    switch(editorType) {
        case "simple":
        document.execCommand(editorCmd,false,editorAttr);
        break;      
        case "link":
        document.execCommand("createLink",false,getSelection().startContainer.wholeText);
        break;
        
    }
    $(".geditor").focus();

}
handler("click",".btn-editor",editorButtonHandler);
