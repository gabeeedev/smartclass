//
//Form data
//

function getFormInputs(formId) {
    // console.log($("#" + formId + " input"));
    t = {};
    $("#" + formId + " input").each((k, v) => {
        if ($(v).attr("type") == "checkbox") {
            t[v.id] = $(v).is(":checked");
        } else {
            t[v.id] = $(v).val();
        }
    });

    $("#" + formId + " select").each((k, v) => {
        t[v.id] = v.value;
    });

    $("#" + formId + " .geditor").each((k,v) => {
        t[v.id] = $(v).html();
    })

    return t;
}

function checkEdit(id, data) {
    if ($("#" + id).length > 0) {
        data[id] = $("#" + id).val();
    }
}

//
//File names
//
function showFileName() {
    $("[for='" + $(this).attr("id") + "']").html($(this).val().split('\\').slice(-1)[0]);
}
handler("change", "[type=file]",showFileName);
//
//Resizable textarea
//

function resizeTextarea(e) {
    console.log($(this)[0].scrollHeight);
    $(this).height(0);
    $(this).height($(this)[0].scrollHeight - 16);
}
handler("change keyup", ".resize-textarea", resizeTextarea);

//
//Timers
//

var Timers = [];
var IntervalHandler = setInterval(refreshTimers,1000);

function resetTimers() {
    Timers.length = 0;
    loadTimers();
}

function loadTimers() {

    timerRefreshHandler = function() {
        loadContent(LastPage.content,LastPage.contentOptions);
    };

    $("[timer]").each((k,v) => {
        switch ($(v).attr("callback")) {
            case "refresh":
                callback = timerRefreshHandler;
                break;
        
            default:
                callback = timerDefaultCallback;
                break;
        }
        registerTimer(parseInt(($(v).attr("timer"))), $(v), callback);
    })

    refreshTimers();
}

function timerDefaultCallback(timer) {
    timer.dom.html("Time up!");
}

function refreshTimers() {
    Timers.forEach(v => {
        if (v.time > 0) {
            v.time -= 1;
            v.dom.html(moment.duration(v.time,"seconds").format("hh:mm:ss"));         
        } else {
            if (!v.finished) {
                v.finished = true;
                if (v.callback != undefined) {
                    setTimeout(v.callback,1000,v);
                }
            }
        }
        
    });
}

function registerTimer(time, dom, callback) {
    Timers.push({
        "time":time,
        "dom":dom,
        "callback":callback,
        "finished":false
    })
}

//
//Popup
//

function showPopup(popupText, popupHandler, data) {
    $(".popup-center").show();
    $(".popup-header").html(popupText.header);
    $(".popup-text").html(popupText.text);
    $(".popup-btn").html(popupText.button);
    overwriteHandler("click", ".popup-btn", function () {
        popupHandler(data);
        $(".popup-center").hide();
    })
}
handler("click", ".popup-cancel", function () {
    $(".popup-center").hide();
})

function deletePopup(e) {
    e.preventDefault();
    text = $(this).attr("delete_popup");
    service = $(this).attr("delete_service");
    id = $(this).attr("delete_id");
    popupText = {
        "header": "Delete " + text,
        "text": "Are you sure want to delete: " + text + "?",
        "button": "Delete"
    };
    showPopup(popupText, deleteHandler, {
        "service": service,
        "id": id
    });
}
handler("click", "[delete_popup]", deletePopup)

function archivePopup(e) {
    e.preventDefault();
    text = $(this).attr("archive_popup");
    service = $(this).attr("archive_service");
    id = $(this).attr("archive_id");
    popupText = {
        "header": "Archive " + text,
        "text": "Are you sure want to archive: " + text + "?",
        "button": "Archive"
    };
    showPopup(popupText, deleteHandler, {
        "service": service,
        "id": id
    });
}
handler("click", "[archive_popup]", archivePopup);