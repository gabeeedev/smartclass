<?php

require_once("auth.php");

function isTeacher($cid) {
    return sql_select_unique("SELECT * FROM teaches JOIN courses ON course=courseid WHERE user = ? AND course = ?",[$_SESSION["user"]["userid"],$cid]);
}

function isStudent($cid) {
    return sql_select_unique("SELECT * FROM attends JOIN courses ON course=courseid WHERE user = ? AND course = ?",[$_SESSION["user"]["userid"],$cid]);
}

function setCurrentCourse($cid) {
    $_SESSION["course"] = [];
    $_SESSION["course"]["id"] = $cid;
    
    if (isTeacher($cid)) {    
        $_SESSION["course"]["as"] = "teacher";
    } else if(isStudent($cid)) {
        $_SESSION["course"]["as"] = "student";
    }
}

function asTeacher() {
    return isset($_SESSION["course"]) && isset($_SESSION["course"]["as"]) && $_SESSION["course"]["as"] == "teacher";
}

function asStudent() {
    return isset($_SESSION["course"]) && isset($_SESSION["course"]["as"]) && $_SESSION["course"]["as"] == "student";
}