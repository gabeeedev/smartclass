<?php

/**
 * Quiz solution
 * quizId - Quiz ID
 * quizAnswers - Quiz answers
 */

require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();

if (checkPostData(["quizId","quizAnswers"])) {

    $quizId = $_POST["quizId"];
    $fill = sql_select_unique("SELECT * FROM quiz_fills, quizes WHERE user = ? AND quiz = ? AND quiz = quizId",[$_SESSION["user"]["userId"],$quizId]);
    if (timeDiff(getCurrentTime(),$fill["startTime"]) <= $fill["length"]*60) {
        $data = [];

        foreach($_POST["quizAnswers"] as $qid => $answer) {
            array_push($data,[json_encode($answer),$fill["quizFillId"],$qid]);
        }

        sql_multiple_update_by_id("quiz_answers",["quizFillId","qid"],["answer"],$data);

        sql_update_by_id("quiz_fills",["finishTime" => getCurrentTime()],"quizFillId",$fill["quizFillId"]);
    }
}