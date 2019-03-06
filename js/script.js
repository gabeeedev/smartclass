function load(page, tar) {
    $.get(page,function(data) {
        $(tar).html(data);
        refreshCallbacks();
    });
}

function loadPage(page) {
    load(page,"#content");
}

function loadService(service,tar) {
    load("api/services/" + service,tar);
}

function refreshCallbacks() {
    $("[redirect]").click(function(e) {
        e.preventDefault();
        target = "body";
        service = $(this).attr("redirect");
        if($(this).attr("target")) {
            target = $(this).attr("target");
        }
        loadService(service, target);
    });
}

$(document).ready(function() {
    load("api/services/startService.php","body");
});