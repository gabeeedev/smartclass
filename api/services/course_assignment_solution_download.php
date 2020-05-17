<?php

require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();

$fileId = $_GET["id"];

$file = sql_select_unique("SELECT * FROM assignment_files af, assignments a WHERE aFileId = ? AND af.assignment = a.assignmentId",[$fileId]);
$user = sql_select_unique("SELECT * FROM users WHERE userId = ?",[$file["user"]]);

if (teachesCourse($file["course"])) {
    $title = $file["title"] . " - " . $user["name"];
    downloadFile("assignments/" . $file["filePath"],$title);
}