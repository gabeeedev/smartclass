<?php

require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();
if (checkPostData(["votingTitle","votingDescription","votingFrom","votingTo","votingAnswers"]) && asTeacher()) {
    $id = sql_insert("voting",[
        "title" => $_POST["votingTitle"],
        "description" => $_POST["votingDescription"],
        "available_from" => $_POST["votingFrom"],
        "available_to" => $_POST["votingTo"],
        "multiple" => (isset($_POST["votingMultiple"]) && $_POST["votingMultiple"] == "true") ? 1 : 0,
        "anonymous" => (isset($_POST["votingAnonymous"]) && $_POST["votingAnonymous"] == "true") ? 1 : 0,
        "result" => (isset($_POST["votingResult"]) && $_POST["votingResult"] == "true") ? 1 : 0,
        "course" => $_SESSION["course"]["id"]
    ]);

    $data = [];

    foreach ($_POST["votingAnswers"] as $v) {
        array_push($data,[$v,$id]);
    }

    sql_multiple_insert("voting_options",["title","voting"],$data);
}