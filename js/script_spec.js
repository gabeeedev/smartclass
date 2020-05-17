//
//Testing
//

function testerHandler(e) {

    e.preventDefault();
    tester = $(this).parent().parent();
    tar = tester.attr("tester");
    $.get("api/tests/" + tar + ".php", function (data) {
        tester.find("[test_log]").html(data);
        tester.find("[test_log]").show(500);
    });

}
handler("click", "[tester] [test_run]", testerHandler);

function toggleTestLog(e) {
    e.preventDefault();
    log = $(this).parent().parent().find("[test_log]");
    if (log.html().length != 0) {
        log.toggle(500);
    }
}
handler("click", "[tester] h4", toggleTestLog);

function runAllTests(e) {
    e.preventDefault();
    $("[tester]").each(function (k, v) {
        tar = $(v).attr("tester");
        $.get("api/tests/" + tar + ".php", function (data) {
            $(v).find("[test_log]").html(data);
            $(v).find("[test_log]").show(500);
        });

    })
}
handler("click", "[test_run_all]", runAllTests);