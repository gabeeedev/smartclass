//
//User
//
function login(e) {

    e.preventDefault();
    data = getFormInputs("loginForm");

    $.post("api/services/login.php", data, function (data) {
        if (data == "1") {
            loadPage("index", {}, "main_home", {});
        } else {
            $("#loginErrors").html(data);
        }
    });
}
handler("submit", "#loginForm", login);

function register(e) {
    e.preventDefault();
    data = getFormInputs("registerForm");

    $.post("api/services/register.php", data, function (data) {
        if (data == "1") {
            loadPage("index", {}, "main_home", {});
        } else {
            $("#registerErrors").html(data);
        }
    }
    );
}
handler("submit", "#registerForm", register);

function logout() {
    $.get("api/services/logout.php", function () {
        loadPage("index", {}, "main_home", {});
    })
}
handler("click", "[request=logout]", logout);

function userSettingsEdit(e) {
    e.preventDefault();

    data = getFormInputs("userSettings");

    $.post("api/services/user_settings_edit.php", data, function (data) {
        loadContent("user_settings");
    });
}
handler("submit", "#userSettings", userSettingsEdit);

function userPasswordEdit(e) {
    e.preventDefault();

    data = getFormInputs("passwordSettings");

    $.post("api/services/user_password_edit.php", data, function (data) {
        if(data == "1") {
            loadContent("user_settings");
        }
        else {
            $("#passwordEditErrors").html(data);
        }
    });
}
handler("submit", "#passwordSettings", userPasswordEdit);

//
// Courses
//

function createCourse(e) {
    e.preventDefault();
    $.post("api/services/create_course.php",
        {
            courseName: $("#courseName").val()
        },
        function (data) {
            console.log(data);
            data = JSON.parse(data);
            if ("id" in data) {
                loadPage("course", { "course": data["id"] }, "course_home", {});
            } else {
                $("#courseNameError").html(data["error"]);
            }
        });
}
handler("submit", "#createCourse", createCourse);

function joinCourse(e) {
    e.preventDefault();
    $.post("api/services/join_course.php",
        {
            courseToken: $("#courseToken").val()
        },
        function (data) {
            console.log(data);
            data = JSON.parse(data);
            if ("id" in data) {
                loadPage("course", { "course": data["id"] }, "course_home", {});
            } else {
                $("#courseTokenError").html(data["error"]);
            }
        });
}
handler("submit", "#joinCourse", joinCourse);

function courseSettings(e) {
    e.preventDefault();
    data = {
        "courseTitle": $("#courseTitle").val(),
        "courseStatus": $("#courseStatus").val(),
        "publicCourse": $("#publicCourse").is(":checked")
    }
    $.post("api/services/course_settings_edit.php", data, function (data) {
        loadContent("course_settings");
    });
}
handler("submit", "#courseSettings", courseSettings);


// 
// Materials
//
function materialFileUpload(e) {
    e.preventDefault();

    if ($("#materialFileTitle").val().length == 0) {
        name = $("#materialFile").val();
        name = name.split('\\').slice(-1)[0];
        name = name.split('.').slice(0, -1).join('.')
        $("#materialFileTitle").val(name);
    }

    button = $("#materialFileForm button");
    button.prop("disabled", true);
    button.html('<i class="material-icons">loud_upload</i>');
    uploadFile("materialFileForm", "api/services/material_file_upload.php", function (data) {
        data = JSON.parse(data);
        if (data.success) {

            s = "<div class='py-2 f-row'><div class='border border-success p-3 rounded d-flex flex-row'>" +
                "<div class='flex-max'><b>" + data.title + "</b></div>" +
                "<div class='flex-static'><small>" + data.file + "</small></div>" +
                "<div></div>";

            $("#materialFileList").append(s);

            //Clear
            $("#materialFileTitle").val("");
            $("#materialFile").val("");
            $("[for='materialFile']").html("Choose file");
        } else {

        }
        button.prop("disabled", false);
        button.html('Upload');
    });
}
handler("submit", "#materialFileForm", materialFileUpload);

function materialEdit(e) {
    e.preventDefault();
    data = getFormInputs("materialForm");

    $.post("api/services/material_edit.php", data, function (data) {
        data = JSON.parse(data);
        if (data.success) {
            loadContent("material_list");
        }
    });
}
handler("submit", "#materialForm", materialEdit);

function materialShare(e) {
    e.preventDefault();
    data = getFormInputs("materialShareForm");
    $.post("api/services/course_material_share.php", data, function (data) {
        loadContent("course_material_list");
    });
}
handler("submit", "#materialShareForm", materialShare);

//
//Posts
//

function coursePost(e) {
    e.preventDefault();
    data = { "postContent": $("#postContent").val().replace(/\n/g, "<br>") };
    $.post("api/services/course_post_edit.php", data, function (data) {
        if(data == "1") {
            loadContent("course_home");
        }
    })
}
handler("submit", "#postForm", coursePost);

function commentPost(e) {
    e.preventDefault();
    data = {
        "commentContent": $(this).find("textarea").val().replace(/\n/g, "<br>"),
        "postId": $(this).attr("postId")
    };
    $.post("api/services/course_comment_edit.php", data, function (data) {
        if(data == "1") {
            loadContent("course_home");
        }
    })
}
handler("submit", ".commentForm", commentPost);

//
//Assignments
//

function assigmentEdit(e) {
    e.preventDefault();

    ext = $("#assignmentExt").val().split(/,[ ]*|,/);
    ext = ext.map(x => x.toLowerCase());
    ext = Array.from(new Set(ext));

    data = {
        "assignmentTitle": $("#assignmentTitle").val(),
        "assignmentContent": $("#assignmentContent").html(),
        "assignmentFrom": $("#fromPicker").val(),
        "assignmentTo": $("#toPicker").val(),
        "assignmentExt": ext
    }
    checkEdit("assignmentEdit", data);

    $.post("api/services/course_assignment_edit.php", data, function (data) {
        if (data == "1") {
            loadContent("course_assignment_list");
        }
    });

}
handler("submit", "#assignmentForm", assigmentEdit);

function assignmentSolution(e) {
    e.preventDefault();
    uploadFile("assignmentSolutionForm", "api/services/course_assignment_solution.php", function (data) {
        if (data != 0) {
            loadContent("course_assignment", { "id": data });            
        }
    });
}
handler("submit", "#assignmentSolutionForm", assignmentSolution);

//
//Grading
//

function gradingEdit(e) {
    e.preventDefault();
    data = {
        "gradingTitle": $("#gradingTitle").val(),
        "gradingDescription": $("#gradingDescription").val(),
        "gradingMin": $("#gradingMin").val(),
        "gradingMax": $("#gradingMax").val(),
        "gradingPublicScores": $("#gradingPublicScores").is(":checked")
    };
    checkEdit("gradingEdit", data);
    $.post("api/services/course_grading_edit.php", data, function (data) {
        console.log(data);
        if(data != 0) {
            loadContent("course_grading",{"id":data});
        }
    });
}
handler("submit", "#gradingForm", gradingEdit);

function saveGrades(e) {
    e.preventDefault();

    $(this).attr("disabled", true);
    $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Saving...');

    grades = [];

    $("tr[uid]").each(function () {
        grades.push({
            "id": $(this).attr("uid"),
            "grade": $(this).find("[data=gradeGrade]").val(),
            "comment": $(this).find("[data=gradeComment]").val()
        });
    });

    data = {
        "grading": $("#gradingId").val(),
        "grades": grades
    }

    $.post("api/services/course_grades_edit.php", data, function (data) {
        $("#saveGradesButton").attr("disabled", false);
        $("#saveGradesButton").html('Saved');
        loadContent("course_grading_list");
    });
}
handler("click", "#saveGradesButton", saveGrades);

//
//Votes
//
function votingEdit(e) {
    e.preventDefault();
    data = {
        "votingTitle": $("#votingTitle").val(),
        "votingDescription": $("#votingDescription").val(),
        "votingFrom": $("#fromPicker").val(),
        "votingTo": $("#toPicker").val(),
        "votingMultiple": $("#votingMultiple").is(":checked"),
        "votingAnonymous": $("#votingAnonymous").is(":checked"),
        "votingResult": $("#votingResult").is(":checked"),
        "votingAnswers": $("[name=votingAnswer]").map(function () { return $(this).val(); }).get()
    };
    console.log(data);

    $.post("api/services/course_voting_edit.php", data, function (data) {
        console.log(data);
        if(data == 1) {
            loadContent("course_voting_list");
        }
    });
}
handler("submit", "#votingForm", votingEdit);

function votingVote(e) {
    e.preventDefault();

    t = $("[name=votingChoice").map(function () {
        return {
            "id": $(this).attr("vote"),
            "value": $(this).is(":checked")
        };
    });

    data = {
        "voting": $("#votingId").val(),
        "votes": t.get()
    };


    $.post("api/services/course_voting_vote.php", data, function (data) {
        console.log(data);
        loadContent("course_voting",{ id: $("#votingId").val() });
    });
}
handler("submit", "#votingVote", votingVote);

//
//Quizes, quiz banks
//

function bankEdit(e) {
    e.preventDefault();
    data = {};
    data.bankTitle = $("#bankTitle").val();
    data.bankQuestions = [];

    $("[quiz-question]").each((i,question) => {
        t = {
            "question":$(question).find("[name=questionTitle]").val(),
            "type":$(question).attr("type")
        }

        switch ($(question).attr("type")) {
            case "choice":
            case "multichoice":
                t.answers = $(question).find(".quiz-option").map((k,v) => $(v).val()).get();
                break;        
            default:
                break;
        }
        data.bankQuestions.push(t);
    });

    $.post("api/services/quiz_bank_edit.php",data,function(data) {
        loadContent("quiz_bank_list");
    });
}
handler("submit","#bankForm",bankEdit);

function quizEdit(e) {
    e.preventDefault();
    data = getFormInputs("quizForm");
    console.log(data);
    $.post("api/services/course_quiz_edit.php",data,function(data) {
        loadContent("course_quiz_list");
        console.log(data);
    });
}
handler("submit","#quizForm",quizEdit);

function quizBegin(e) {
    e.preventDefault();

    id = $(this).attr("quizId");

    $.post("api/services/course_quiz_begin.php",{"quizId":id},function(data) {
        loadContent("course_quiz",{"id":id});
        console.log(data);
    });
}
handler("click","#quizBegin",quizBegin);

function quizFill(e) {
    e.preventDefault();

    data = {
        "quizId":$(this).attr("quizId"),
        "quizAnswers":{}
    };

    $("[quiz-answer]").each((k,v) => {
        var id = $(v).attr("qid");
        var type = $(v).attr("type");
        var answer;

        switch (type) {
            case "text":
            case "number":
                answer = $(v).find("input").val();
                break;
            case "choice":
                answer = $(v).find("input:checked").val();
                break;
            case "multichoice":
                answer = $(v).find("input:checked").map((k,v) => $(v).val()).get();
                break;
            default:
                break;
        }
        data.quizAnswers[id] = answer;
    });

    $.post("api/services/course_quiz_fill.php",data,function(data) {
        loadContent("course_quiz_list");
        console.log(data);
    });
}
handler("submit","#quizFillForm",quizFill);

function quizGetFilled(e) {
    $.get("api/controllers/course_quiz_filled.php",{"quizFillId":$("#quizFillStudent").val()},function(data) {
        $("#quizFilled").html(data);
    })
}
handler("change","#quizFillStudent",quizGetFilled);

//
//Download
//

function downloadHandler(e) {
    downloader = $(this).attr("downloader");
    id = $(this).attr("id");
    window.open("api/services/" + downloader + ".php?id=" + id, "_self");

}
handler("click", "[downloader]", downloadHandler);

//
//Delete & Archive
//

function deleteHandler(data) {
    $.post("api/services/" + data.service + ".php", { "id": data.id }, function (data) {
        loadContent(LastPage.content,LastPage.contentOptions);
        console.log(data);
    });
}

function archiveHandler() {
    $.post("api/services/" + data.service + ".php", { "id": data.id }, function () {
        loadContent(LastPage.content,LastPage.contentOptions);
    });
}

//
// Utility
//

function uploadFile(formId, target, feedback) {
    var formData = new FormData(document.getElementById(formId));
    $.ajax({
        url: target,
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
        success: feedback
    });
}