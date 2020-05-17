<?php

require_once "../util/auth.php";
require_once "../util/util.php";

loginDie();

$id = $_POST["id"];

$assignment = sql_select_unique("SELECT * FROM assignments WHERE assignmentId = ?",[$id]);
$teaches = sql_select("SELECT * FROM teaches WHERE course = ? AND user = ?",[$assignment["course"],$_SESSION["user"]["userId"]]);

if ($teaches !== false) {
    
    $count = sql_delete("DELETE FROM assignments WHERE assignmentId = ?",[$id]);

    if ($count > 0) {
        $files = sql_select("SELECT * FROM assignment_files WHERE assignment = ?",[$id]);

        foreach($files as $row) {
            unlink("../../files/assignments/" . $row["filePath"]);
        }

        sql_delete("DELETE FROM assignment_files WHERE assignment = ?",[$id]);
    }

}