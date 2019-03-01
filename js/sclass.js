function load(page, tar) {
    $.get(page,function(data) {
        $(tar).html(data);
    });
}

function loadPage(page) {
    load(page,"#content");
}

$(document).ready(function() {
    load("api/menu.php","#menu");
});