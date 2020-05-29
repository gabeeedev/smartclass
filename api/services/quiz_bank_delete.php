<?php

/**
 * Delete quiz bank
 * id - Quiz bank ID
 */

require_once "../util/auth.php";
require_once "../util/util.php";

loginDie();

$id = $_POST["id"];

$count = sql_delete("DELETE FROM quiz_banks WHERE bankId = ? AND author = ?",[$id,$_SESSION["user"]["userId"]]);

if ($count > 0) {
    sql_delete("DELETE FROM quiz_questions WHERE bank = ?",[$id]);

    sql_delete("DELETE FROM quiz_answers WHERE quizFillId IN (SELECT quizFillId FROM quiz_fills WHERE quiz IN (SELECT quizId FROM quizes WHERE bank = ?))",[$id]);
    sql_delete("DELETE FROM quiz_fills WHERE quiz IN (SELECT quizId FROM quizes WHERE bank = ?)",[$id]);
    sql_delete("DELETE FROM quizes WHERE bank = ?",[$id]);
}

