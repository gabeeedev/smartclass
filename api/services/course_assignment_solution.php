<?php

require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();

$user = $_SESSION["user"]["userid"];
$course = $_SESSION["course"]["id"];
$assignment = $_POST["assignmentId"];

if (isset($_FILES["assignmentSolution"]) && $_FILES["assignmentSolution"]["error"] == 0) {
    $row = sql_select_unique("SELECT * FROM assignment_files WHERE user = ? AND assignment = ?",[$user,$assignment]);
    $file = getFile($_FILES["assignmentSolution"]["name"]);
    $fileName = $course . "_" . $assignment . "_" . $user . "." . $file["ext"];
    if ($row === false) {
        sql_insert("assignment_files",[
            "user" => $user,
            "assignment" => $assignment,
            "file" => $fileName
        ]);
    }
    else {
        sql_update_by_id("assignment_files",["file" => $fileName],"afileid",$row["afileid"]);

        if (file_exists("../files/assignments/" . $row["file"])) {
            unlink("../files/assignments/" . $row["file"]);
        }
    }
    
    move_uploaded_file($_FILES["assignmentSolution"]["tmp_name"],"../files/assignments/" . $fileName);
    echo $assignment;
}
