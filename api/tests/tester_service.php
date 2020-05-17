<?php

require_once "tester.php";

function runService($service,$session = array(), $post = array(), $get = array()) {

    $tempSession = $_SESSION;
    $tempPost = $_POST;
    $tempGet = $_GET;

    $_SESSION = $session;
    $_POST = $post;
    $_GET = $get;

    ob_start();
    include $service;
    $resp = ob_get_clean();

    $temp = ["session" => $_SESSION, "post" => $_POST, "get" => $_GET, "resp" => $resp];

    $_SESSION = $tempSession;
    $_POST = $tempPost;
    $_GET = $tempGet;

    return $temp;
}

$mockUser = ["username" => "mockuser", "email" => "mock@user.mu", "password" => "1234", "name" => "Mock User"];

function addMockUser() {
    global $mockUser;

    $t = $mockUser;
    $t["password"] = makePassword($t["password"]);

    $userid = sql_insert("users",$t);
    $mockUser["userId"] = $userid;
}

function removeMockUser() {
    global $mockUser;

    sql_delete("DELETE FROM users WHERE userId = ?",[$mockUser["userId"]]);
    unset($mockUser["userId"]);
}

$mockCourse = ["title" => "Mock Course", "token" => "AAAAAAA", "status" => "0"];

function addMockCourse($role = "teaches") {
    global $mockCourse;
    global $mockUser;

    $courseId = sql_insert("courses",$mockCourse);
    $mockCourse["courseId"] = $courseId;
    sql_insert($role,["course" => $courseId,"user" => $mockUser["userId"]]);
}

function removeMockCourse() {
    global $mockCourse;
    global $mockUser;

    sql_delete("DELETE FROM courses WHERE courseId = ?",[$mockCourse["courseId"]]);
    sql_delete("DELETE FROM teaches WHERE courseId = ?",[$mockUser["userId"]]);
    sql_delete("DELETE FROM attends WHERE courseId = ?",[$mockUser["userId"]]);
    unset($mockCourse["courseId"]);
}