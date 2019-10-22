<?php

require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();
if (checkPostData(["assignmentTitle","assignmentContent","assignmentFrom","assignmentTo","assignmentExt"]) && asTeacher()) {
    sql_insert("assignments",[
        "title" => $_POST["assignmentTitle"],
        "content" => $_POST["assignmentContent"],
        "available_from" => $_POST["assignmentFrom"],
        "available_to" => $_POST["assignmentTo"],
        "extensions" => implode(",",$_POST["assignmentExt"]),
        "course" => $_SESSION["course"]["id"]
    ]);
}
