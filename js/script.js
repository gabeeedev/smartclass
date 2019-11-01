var MENU_STATE = 1;
var headerGuards = {};
function def(s)
{
    headerGuards[s] = true;
}

function ifndef(s) {
    return !(headerGuards[s] === true);
}

function handler(events, target, func) {
    $(document).on(events,target,func);
}

function load(page, tar, options={},save=true) {
    console.log("Load: " + page + " to " + tar);
    $(tar).fadeOut(200, function() {
        $.get(page,options,function(data) {
            $(tar).html(data);
            
            if(save) {
                history.pushState({"page":page,"options":options,"target":tar},null,null);
            }
            // refreshCallbacks();
            fixMenu();
            $(tar).fadeIn(200);
        });
    });
}

function loadPage(page,options={}) {
    load(page,"#content",options);
}

function loadController(controller,tar,options={}) {
    load("api/controllers/" + controller + ".php",tar,options);
}

function redirect(e) {
    e.preventDefault();
    var target = "#page";
    var controller = $(this).attr("redirect");
    var options = {};
    if($(this).attr("target")) {
        target = $(this).attr("target");
    }
    if($(this).attr("options")) {
        var t = $(this).attr("options").split(",");
        t.forEach(v => {
            var opt = v.split(":");
            options[opt[0]] = opt[1];
        });        
    }
    loadController(controller, target, options);
}
handler("click","[redirect]",redirect);

function getFormInputs(formId) {
    // console.log($("#" + formId + " input"));
    t = {};
    $("#" + formId + " input").each((k,v) => {
        t[v.id] = v.value;
    });

    $("#" + formId + " select").each((k,v) => {
        t[v.id] = v.value;
    });
    return t;
}

function login(e) {
    
    e.preventDefault();
    data = getFormInputs("loginForm");

    $.post("api/services/login.php",data,function(data) {
            loadController("index","#page");
        }
    );
}
handler("submit","#loginForm",login);

function register(e) {
    e.preventDefault();
    data = getFormInputs("registerForm");
    console.log(data);

    $.post("api/services/register.php",data,function(data) {
            if(data == "1") {
                loadController("index","#page");
            } else {
                $("#registerErrors").html(data);             
            }
        }
    );
}
handler("submit","#registerForm",register);

function logout() {
    $.get("api/services/logout.php", function() {
        loadController("index","#page");
    })
}
handler("click","[request=logout]",logout);

function fixMenu() {
    var px = MENU_STATE == 1 ? "224px" : "64px";
    $("#menu").css("width",px);
    $("#content").css("marginLeft",px);
}

function toggleMenu() {

    MENU_STATE = 1 - MENU_STATE;
    var px = MENU_STATE == 1 ? "224px" : "64px";    

    $("#menu").animate({
        width:px
    },500);

    $("#content").animate({
        marginLeft:px
    },500);
}
handler("click",".menu-control",toggleMenu);

function createCourse(e) {
    e.preventDefault();
    $.post("api/services/create_course.php",
    {
        courseName:$("#courseName").val()
    },
    function(data) {
        data = JSON.parse(data);
        if ("id" in data) {
            loadController("course","#page",{"course":data["id"]});
        } else {
            $("#courseNameError").html(data["error"]);
        }
    });
}
handler("submit","#createCourse",createCourse);

function joinCourse(e) {
    e.preventDefault();
    $.post("api/services/join_course.php",
    {
        courseToken:$("#courseToken").val()
    },
    function(data) {
        console.log(data);
        data = JSON.parse(data);
        if ("id" in data) {
            loadController("course","#page",{"course":data["id"]});
        } else {
            $("#courseTokenError").html(data["error"]);
        }
    });
}
handler("submit","#joinCourse",joinCourse);

$(document).ready(function() {
    window.onpopstate = stateHandler;
    // state = window.history.state;
    // load(state.page,state.target,state.options,false);
    loadController("index","#page");
});

function stateHandler(data) {
    if (data.state != null) {
        state = data.state;
        load(state.page,state.target,state.options,false);
    }
}

function changeListStyle(e) {
    
    to = $(e.target).attr("list-to");
    cur = $(".list-changeable").attr("list-style");
    $(".list-changeable > div").each(function(k,v) {
        $(v).removeClass(cur);
        $(v).addClass(to);
    });
    $(".list-changeable").attr("list-style",to);
}
handler("click",".list-changer",changeListStyle);

// 
// File upload
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

handler("change","#materialFile",function(e) {    
    $("[for='materialFile']").html($("#materialFile").val().split('\\').slice(-1)[0]);
})

// 
// Materials
// 
function materialFileUpload(e) {
    e.preventDefault();
    button = $("#materialFileForm button");
    button.prop("disabled",true);
    button.html('<i class="material-icons">loud_upload</i>');
    uploadFile("materialFileForm","api/services/material_file_upload.php",function(data) {
        data = JSON.parse(data);
        if (data.success) {

            s = "<div class='py-2 f-row'><div class='border border-success p-3 rounded d-flex flex-row'>" +
            "<div class='flex-max'>" + data.title + "</div>" +
            "<div class='flex-static'>" + data.file + "</div>" +
            "<div></div>"
            
            $("#materialFileList").append(s);
        } else {

        }
        button.prop("disabled",false);  
        button.html('Upload');      
    });
}
handler("submit","#materialFileForm",materialFileUpload);

function materialSubmit(e) {
    e.preventDefault();
    data = getFormInputs("materialForm");
    data.materialContent = $("#" + $("#materialContent").attr("medium-editor-textarea-id")).html();
    
    $.post("api/services/material_edit.php",data,function(data) {
        data = JSON.parse(data);
        if (data.success) {
            loadController("material_list","#content");
        }
    });
}
handler("submit","#materialForm",materialSubmit);

function materialShare(e) {
    e.preventDefault();
    data = getFormInputs("materialShareForm");
    $.post("api/services/course_material_share.php",data,function(data) {
        console.log(data);
        loadController("course_materials","#content",{"course":data});
    });    
}
handler("submit","#materialShareForm",materialShare);

function coursePost(e) {
    e.preventDefault();
    data = {"postContent":$("#postContent").val().replace(/\n/g,"<br>")};
    $.post("api/services/course_post_edit.php",data,function(data) {
        console.log(data);
        loadController("course_home","#content",{"course":data});
    })
}
handler("submit","#postForm",coursePost);

function commentPost(e) {
    e.preventDefault();
    data = {
        "commentContent":$(this).find("textarea").val().replace(/\n/g,"<br>"),
        "postId":$(this).attr("postId")
    };
    $.post("api/services/course_comment_edit.php",data,function(data) {
        loadController("course_home","#content",{"course":data});
    })
}
handler("submit",".commentForm",commentPost);

function resizeTextarea(e) {
    console.log($(this)[0].scrollHeight);
    $(this).height(0);
    $(this).height($(this)[0].scrollHeight-16);
}
handler("change keyup",".resize-textarea",resizeTextarea);

function assigmentEdit(e) {
    e.preventDefault();

    ext = $("#assignmentExt").val().split(/,[ ]*|,/);
    ext = ext.map(x => x.toLowerCase());
    ext = Array.from(new Set(ext));

    data = {
        "assignmentTitle":$("#assignmentTitle").val(),
        "assignmentContent":$("#" + $("#assignmentContent").attr("medium-editor-textarea-id")).html(),
        "assignmentFrom":$("#fromPicker").val(),
        "assignmentTo":$("#toPicker").val(),
        "assignmentExt":ext
    }

    $.post("api/services/course_assignment_edit.php",data,function(data) {
        loadController("course_assignment_list","#content");
    });

}
handler("submit","#assignmentForm",assigmentEdit);

function assignmentSolution(e) {
    e.preventDefault();
    uploadFile("assignmentSolutionForm","api/services/course_assignment_solution.php",function(data) {
        loadController("course_assignment","#content",{"id":data});
    });
}
handler("submit","#assignmentSolutionForm",assignmentSolution);

function gradingEdit(e) {
    e.preventDefault();
    data = {
        "gradingTitle": $("#gradingTitle").val(),
        "gradingDescription": $("#gradingDescription").val(),
        "gradingMin":$("#gradingMin").val(),
        "gradingMax":$("#gradingMax").val(),
        "gradingPublicScores":$("#gradingPublicScores").is(":checked")
    };
    console.log(data);
    $.post("api/services/course_grading_edit.php",data,function(data) {
        console.log(data);
        // loadController("course_grading_list","#content");
    });
}
handler("submit","#gradingForm",gradingEdit);

function saveGrades(e) {
    e.preventDefault();

    $(this).attr("disabled",true);
    $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Saving...');

    grades = [];

    $("tr[uid]").each(function() {
        grades.push({
            "id":$(this).attr("uid"),
            "grade":$(this).find("[data=gradeGrade]").val(),
            "comment":$(this).find("[data=gradeComment]").val()
        });
    });

    data = {
        "grading":$("#gradingId").val(),
        "grades":grades
    }
    
    $.post("api/services/course_grades_edit.php",data,function(data) {
        $("#saveGradesButton").attr("disabled",false);
        $("#saveGradesButton").html('Saved');
        loadController("course_grading_list","#content");
    });
}
handler("click","#saveGradesButton",saveGrades);