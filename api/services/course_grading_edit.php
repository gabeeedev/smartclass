<?php

/**
 * New or modify grading
 * gradingTitle - Grading title
 * gradingDescription - Grading description
 * gradingMin - Grading minimum points
 * gradingMax - Grading maximum points
 * publicScores - Should the grades be public
 */

require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();
if (checkPostData(["gradingTitle","gradingDescription","gradingMin","gradingMax"]) && asTeacher()) {

    $edit = isset($_POST["gradingEdit"]) ? $_POST["gradingEdit"] : false;
    if ($edit !== false) {
        $row = sql_select_unique("SELECT course FROM gradings WHERE gradingId = ?",[$edit]);
        if ($row === false || !teachesCourse($row["course"])) {
            $edit = false;
        }
    }

    $data = [
        "title" => $_POST["gradingTitle"],
        "description" => $_POST["gradingDescription"],
        "minPoints" => $_POST["gradingMin"],
        "maxPoints" => $_POST["gradingMax"],
        "publicScores" => (isset($_POST["gradingPublicScores"]) && $_POST["gradingPublicScores"] == "true") ? 1 : 0,
    ];

    if ($edit === false) {
        $data["course"] = $_SESSION["course"]["id"];
        $id = sql_insert("gradings",$data);
    } else {
        $id = $edit;
        sql_update_by_id("gradings",$data,"gradingId",$edit);
    }
    echo $id;
} else {
    echo "0";
}
