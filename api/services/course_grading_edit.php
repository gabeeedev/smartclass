<?php

require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();
if (checkPostData(["gradingTitle","gradingDescription","gradingMin","gradingMax"]) && asTeacher()) {
    sql_insert("gradings",[
        "title" => $_POST["gradingTitle"],
        "description" => $_POST["gradingDescription"],
        "min" => $_POST["gradingMin"],
        "max" => $_POST["gradingMax"],
        "public_scores" => (isset($_POST["gradingPublicScores"]) && $_POST["gradingPublicScores"]) ? 1 : 0,
        "course" => $_SESSION["course"]["id"]
    ]);
}
