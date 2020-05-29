<?php

/**
 * Delete course
 * id - Course ID
 */

require_once "../util/auth.php";
require_once "../util/util.php";

loginDie();

$id = $_POST["id"];

$teaches = sql_select("SELECT * FROM teaches WHERE course = ? AND user = ?",[$id,$_SESSION["user"]["userId"]]);

if ($teaches !== false) {
    
    $course = sql_select_unique("SELECT * FROM courses WHERE courseId = ?",[$id]);
    $count = sql_delete("DELETE FROM courses WHERE courseId = ?",[$id]);

    if ($count > 0) {
        
        sql_delete("DELETE FROM material_shared WHERE course = ?",[$id]);
        sql_delete("DELETE FROM course_settings WHERE csetid = ?",[$course["settings"]]);

        sql_delete("DELETE FROM grades WHERE grading IN (SELECT gradingId FROM gradings WHERE course = ?)",[$id]);
        sql_delete("DELETE FROM gradings WHERE course = ?",[$id]);

        $files = sql_select("SELECT * FROM assignment_files WHERE assignment IN (SELECT assignmentId FROM assignments WHERE course = ?)",[$id]);

        foreach($files as $row) {
            unlink("../../files/assignments/" . $row["file"]);
        }

        sql_delete("DELETE FROM assignment_files WHERE assignment IN (SELECT assignmentId FROM assignments WHERE course = ?)",[$id]);
        sql_delete("DELETE FROM assignments WHERE course = ?",[$id]);

        sql_delete("DELETE FROM votes WHERE option IN (SELECT votingOptionId FROM votings v, voting_options vo WHERE v.votingId = vo.voting AND course = ?)",[$id]);
        sql_delete("DELETE FROM votings_options WHERE voting IN (SELECT votingId FROM votings WHERE course = ?)",[$id]);
        sql_delete("DELETE FROM votings WHERE course = ?",[$id]);

    }

}