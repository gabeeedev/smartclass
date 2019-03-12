var MENU_STATE = 1;

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
    e.preventDefault();
    $.post("api/services/create_course.php",
    {
        courseName:$("#courseName").val()
    },
    function(data) {
        data = JSON.parse(data);
        if ("id" in data) {
            loadController("course","#content",{"course":data["id"]});
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
            loadController("course","#content",{"course":data["id"]});
        } else {
            $("#courseTokenError").html(data["error"]);
        }
    });
}
handler("submit","#joinCourse",joinCourse);

$(document).ready(function() {
    window.onpopstate = stateHandler;
    loadController("index","#page");
});

function stateHandler(data) {
    if (data.state != null) {
        state = data.state;
        load(state.page,state.target,state.options,false);
    }
}