<?php

/**
 * Delete grading
 * id - Grading ID
 */

require_once "../util/auth.php";
require_once "../util/util.php";

loginDie();

$id = $_POST["id"];

$grading = sql_select_unique("SELECT * FROM gradings WHERE gradingId = ?",[$id]);
$teaches = sql_select("SELECT * FROM teaches WHERE course = ? AND user = ?",[$grading["course"],$_SESSION["user"]["userId"]]);

if ($teaches !== false) {
    
    $count = sql_delete("DELETE FROM gradings WHERE gradingId = ?",[$id]);

    if ($count > 0) {
        sql_delete("DELETE FROM grades WHERE grading = ?",[$id]);
    }

}