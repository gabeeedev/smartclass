<?php

require_once "../util/util.php";
require_once "../util/auth.php";

if (!isset($testMode) || $testMode !== true) {
    loginDie();
    
    if(!hasRole(1)) {
        exit();
    }
}

$testTimers = [];

function startTimer() {
    global $testTimers;

    array_push($testTimers,microtime(true));
}

function endTimer() {
    global $testTimers;

    $last = array_pop($testTimers);
    return microtime(true) - $last;
}

function TEST_CATEGORY_START($name) {
    echo "<div class='border-test border-primary pl-2 py-1 my-3'>";
    echo "<h4>$name</h4>";
    echo "<div class='pl-4'>";
    startTimer();
}

function TEST_CATEGORY_END() {
    $time = endTimer();
    echo "</div>";
    echo "Finished in " . number_format($time*1000,1) . " ms</div>";
}

function TEST_START($name) {
    echo "<div class='border-test border-secondary pl-2 my-3'>";
    echo "<h5><b>$name</b></h5>";
    echo "<div class='pl-2 pb-2'><small>";
    startTimer();
}

function TEST_END($result) {
    $time = endTimer();
    echo "</small></div>";
    echo "<b class='" . ($result ? "text-success" : "text-danger") . "'>" . ($result ? "Success" : "Failed") . "</b> in " . number_format($time*1000,1) . " ms";
    echo "</div>";
}