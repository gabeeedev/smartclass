<?php

/**
 * Upload assignment solution
 * assignmentId - Assignment ID
 * assignmentSolution - Solution (file)
 */

require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();

$user = $_SESSION["user"]["userId"];
$course = $_SESSION["course"]["id"];
$assignmentId = $_POST["assignmentId"];

if (isset($_FILES["assignmentSolution"]) && $_FILES["assignmentSolution"]["error"] == 0) {
    
    $file = getFile($_FILES["assignmentSolution"]["name"]);

    $assignment = sql_select_unique("SELECT * FROM assignments WHERE assignmentId = ?",[$assignmentId]);

    if ($assignment === false || !attendsCourse($assignment["course"])) {
        echo "0";
        exit();
    }

    $extensions = explode(",",$assignment["extensions"]);

    if (count($extensions) > 0 && array_search($file["ext"],$extensions) === false) {
        echo "0";
        exit();
    }

    $solution = sql_select_unique("SELECT * FROM assignment_files WHERE user = ? AND assignment = ?",[$user,$assignmentId]);    
    $fileName = $course . "_" . $assignmentId . "_" . $user . "." . $file["ext"];
    if ($solution === false) {
        sql_insert("assignment_files",[
            "user" => $user,
            "assignment" => $assignmentId,
            "filePath" => $fileName
        ]);
    }
    else {
        sql_update_by_id("assignment_files",["filePath" => $fileName],"aFileId",$solution["aFileId"]);

        if (file_exists("../../files/assignments/" . $solution["filePath"])) {
            unlink("../../files/assignments/" . $solution["filePath"]);
        }
    }
    
    move_uploaded_file($_FILES["assignmentSolution"]["tmp_name"],"../../files/assignments/" . $fileName);
    echo $assignmentId;
} else {
    echo "0";
}
