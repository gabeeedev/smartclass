<?php

require_once "../util/course.php";
require_once "../util/util.php";

loginDie();

$id = $_POST["id"];

$quiz = sql_select_unique("SELECT * FROM quizes WHERE quizId = ?",[$id]);

if (teachesCourse($quiz["course"])) {
    
    $count = sql_delete("DELETE FROM quizes WHERE quizId = ?",[$id]);
    echo $count;

    if ($count > 0) {
        sql_delete("DELETE FROM quiz_answers WHERE quizFillId IN (SELECT quizFillId FROM quiz_fills WHERE quiz = ?)",[$id]);
        sql_delete("DELETE FROM quiz_fills WHERE quiz = ?",[$id]);
    }

}