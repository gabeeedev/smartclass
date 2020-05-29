<?php

/**
 * New or modofy assignment
 * assignmentTitle - Assignment title
 * assignmentContent - Assignment content
 * assignmentFrom - Assignment available from
 * assignmentTo - Assignment available till
 * assignmentExt - Assignment available extensions
 */

require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();
if (checkPostData(["assignmentTitle","assignmentContent","assignmentFrom","assignmentTo","assignmentExt"]) && asTeacher()) {


    $edit = isset($_POST["assignmentEdit"]) ? $_POST["assignmentEdit"] : false;
    if ($edit !== false) {
        $row = sql_select_unique("SELECT course FROM assignments WHERE assignmentId = ?",[$edit]);
        if ($row === false || !teachesCourse($row["course"])) {
            $edit = false;
        }
    }

    $data = [
        "title" => $_POST["assignmentTitle"],
        "content" => $_POST["assignmentContent"],
        "availableFrom" => $_POST["assignmentFrom"],
        "availableTo" => $_POST["assignmentTo"],
        "extensions" => implode(",",$_POST["assignmentExt"])
    ];

    if ($edit === false) {
        $data["course"] = $_SESSION["course"]["id"];
        sql_insert("assignments",$data);
    } else {
        sql_update_by_id("assignments",$data,"assignmentId",$edit);
    }
    echo "1";
}