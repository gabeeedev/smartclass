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
if (checkPostData(["courseTitle"]) && asTeacher()) {
    $data = [
        "title" => $_POST["courseTitle"],
        "status" => intval($_POST["courseStatus"])
    ];
    sql_update_by_id("courses",$data,"courseId",$_SESSION["course"]["id"]);
}