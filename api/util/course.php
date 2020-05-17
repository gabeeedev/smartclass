<?php

require_once("auth.php");

function teachesCourse($cid) {
    return sql_select_unique("SELECT * FROM teaches WHERE user = ? AND course = ?",[$_SESSION["user"]["userId"],$cid]);
}
function attendsCourse($cid) {
    return sql_select_unique("SELECT * FROM attends WHERE user = ? AND course = ?",[$_SESSION["user"]["userId"],$cid]);
}


function setCurrentCourse($cid) {

    $teacher = sql_select_unique("SELECT * FROM teaches WHERE user = ? AND course = ?",[$_SESSION["user"]["userId"],$cid]);
    $student = sql_select_unique("SELECT * FROM attends WHERE user = ? AND course = ?",[$_SESSION["user"]["userId"],$cid]);

    if ($teacher || $student) {
        $_SESSION["course"] = [];
        $_SESSION["course"]["id"] = $cid;
        $_SESSION["course"]["data"] = sql_select_unique("SELECT * FROM courses WHERE courseId = ?",[$cid]);
        
        $_SESSION["course"]["as"] = $teacher ? "teacher" : "student";
    }
}

function asTeacher() {
    return isset($_SESSION["course"]) && isset($_SESSION["course"]["as"]) && $_SESSION["course"]["as"] == "teacher";
}

function asStudent() {
    return isset($_SESSION["course"]) && isset($_SESSION["course"]["as"]) && $_SESSION["course"]["as"] == "student";
}