var MENU_STATE = 1;

function handler(events, target, func) {
    $(document).on(events,target,func);
}

function load(page, tar) {
    console.log("Load: " + page + " to " + tar);
    $(tar).fadeOut(200, function() {
        $.get(page,function(data) {
            $(tar).html(data);
            // refreshCallbacks();
            $(tar).fadeIn(200);
        });
    });
}

function loadPage(page) {
    load(page,"#content");
}

function loadController(controller,tar) {
    load("api/controllers/" + controller + ".php",tar);
}

function redirect(e) {
    e.preventDefault();
    target = "#page";
    service = $(this).attr("redirect");
    if($(this).attr("target")) {
        target = $(this).attr("target");
    }
    loadController(service, target);
}
handler("click","[redirect]",redirect);

function login(e) {
    e.preventDefault();
    var username = $("#loginUsername").val();
    var password = $("#loginPassword").val();

    $.post("api/services/login.php",
        {
            "username":username,
            "password":password
        },
        function(data) {
            loadController("index","#page");
        }
    );
}
handler("submit","#loginForm",login);

function register(e) {
    e.preventDefault();
    var username = $("#registerUsername").val();
    var email = $("#registerEmail").val();
    var name = $("#registerName").val();
    var password = $("#registerPassword").val();
    var repeatPassword = $("#registerRepeatPassword").val();

    $.post("api/services/register.php",
        {
            "username":username,            
            "email":email,
            "name":name,
            "password":password,
            "passwordRepeat":repeatPassword
        },
        function(data) {
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

function toggleMenu() {

    var px = MENU_STATE == 1 ? "64px" : "224px";
    MENU_STATE = 1 - MENU_STATE;

    $("#menu").animate({
        width:px
    },500);

    $("#content").animate({
        marginLeft:px
    },500);
}
handler("click",".menu-control",toggleMenu);

function createCourse(e) {
    console.log("Hello");
    e.preventDefault();
    $.post("api/services/create_course.php",
    {
        courseName:$("#courseName").val()
    },
    function(data) {
        if (data=="1") {
            loadController("course","#content");
        } else {
            $("#courseNameError").html(data);
        }
    });
}
handler("submit","#createCourse",createCourse);

$(document).ready(function() {
    loadController("index","#page");
});