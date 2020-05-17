var MenuState = 1;
var LastPage = { "page": "index", "pageOptions": {}, "content": "main_home", "contentOptions": {} };

function handler(events, target, func) {
    $(document).on(events, target, func);
}

function overwriteHandler(events, target, func) {
    $(document).off(events, target);
    $(document).on(events, target, func);
}

function loadPage(page, pageOptions = {}, content, contentOptions = {}, save = true) {
    console.log("Loading page: " + page + ", content: " + content);
    $("#page").fadeOut(200, function () {
        $.get("api/controllers/" + page + ".php", pageOptions, function (pageData) {
            $("#page").html(pageData);
            $.get("api/controllers/" + content + ".php", contentOptions, function (contentData) {
                $("#content").html(contentData);

                var t = {
                    "page": page,
                    "pageOptions": pageOptions,
                    "content": content,
                    "contentOptions": contentOptions
                };

                LastPage = t;
                if (save) {
                    history.pushState(t, null, null);          
                }
                fixMenu();
                $("#page").fadeIn(200);
                resetTimers();
            });
        });
    });
}

function loadContent(content, contentOptions = {}, save = true) {
    console.log("Loading content: " + content);
    $("#content").fadeOut(200, function () {
        $.get("api/controllers/" + content + ".php", contentOptions, function (contentData) {
            $("#content").html(contentData);
            var t = {
                "page": LastPage.page,
                "pageOptions": LastPage.pageOptions,
                "content": content,
                "contentOptions": contentOptions
            };
            LastPage = t;
            if (save) {
                history.pushState(t, null, null);
            }
            fixMenu();
            $("#content").fadeIn(200);
            resetTimers();
        });
    });
}

function breakRedirectOptions(str) {

    if (str === undefined || str.length == 0) {
        return {};
    }
    var t = str.split(",");
    var options = {};
    t.forEach(v => {
        var opt = v.split(":");
        options[opt[0]] = opt[1];
    });
    return options;
}

function pageHandler(e) {
    e.preventDefault();

    var pageOptions = breakRedirectOptions($(this).attr("pageOptions"));
    var contentOptions = breakRedirectOptions($(this).attr("contentOptions"));
    loadPage($(this).attr("page"), pageOptions, $(this).attr("sub"), contentOptions);
}
handler("click", "[page]", pageHandler);

function contentHandler(e) {
    e.preventDefault();

    var contentOptions = breakRedirectOptions($(this).attr("contentOptions"));
    loadContent($(this).attr("content"), contentOptions);
}
handler("click", "[content]", contentHandler);

function redirectHandler(e) {
    e.preventDefault();

    var page = $(this).attr("redirect");
    $("#page").fadeOut(200, function() {
        $("#page").load("api/controllers/" + page + ".php", function() {
            $("#page").fadeIn(200);
        });
    });
}
handler("click","[redirect]",redirectHandler);

function loadPrevPage(state) {
    var l = true;

    l = state.page == LastPage.page && l

    if (l) {
        for (var key in state.pageOptions) {
            if (LastPage.pageOptions[key] == undefined || LastPage.pageOptions[key] != state.pageOptions[key]) {
                l = false;
                break;
            }
        }
    }

    if (l) {
        loadContent(state.content,state.contentOptions,false);
    } else {
        loadPage(state.page,state.pageOptions,state.content,state.contentOptions,false);
    }
}

function popStateHandler(e) {
    console.log(e);
    loadPrevPage(e.originalEvent.state);
}
$(window).on("popstate", popStateHandler)

function refreshHandler() {

    if (history.state == null || history.state == undefined) {
        loadPage("index",{},"main_home",{});
    } else {
        loadPage(history.state.page,history.state.pageOptions,history.state.content,history.state.contentOptions);
        // history.pushState(history.state,null,null);
    }
}
$(window).on("load",refreshHandler)

//
//Menu
//

function fixMenu() {
    var px = MenuState == 1 ? "224px" : "64px";
    $("#menu").css("width", px);
    $("#content").css("marginLeft", px);
}

function toggleMenu() {

    MenuState = 1 - MenuState;
    var px = MenuState == 1 ? "224px" : "64px";

    $("#menu").animate({
        width: px
    }, 500);

    $("#content").animate({
        marginLeft: px
    }, 500);
}
handler("click", ".menu-control", toggleMenu);

//
// List style
//

function changeListStyle(e) {

    to = $(e.target).attr("list-to");
    cur = $(".list-changeable").attr("list-style");
    $(".list-changeable > div").each(function (k, v) {
        $(v).removeClass(cur);
        $(v).addClass(to);
    });
    $(".list-changeable").attr("list-style", to);
}
handler("click", ".list-changer", changeListStyle);