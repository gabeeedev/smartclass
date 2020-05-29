<?php

/**
 * Course settings
 * courseTitle - Course title
 * publicCourse - Public course
 * courseId - Course ID
 */


require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();
if (checkPostData(["courseTitle","publicCourse","courseId"]) && asTeacher()) {
    $data = [
        "title" => $_POST["courseTitle"],
        "isPublic" => $_POST["publicCourse"] == "true" ? 1 : 0,
        "status" => intval($_POST["courseStatus"])
    ];
    sql_update_by_id("courses",$data,"courseId",$_SESSION["course"]["id"]);
}