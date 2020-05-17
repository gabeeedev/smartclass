<?php

require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();

$quizId = $_POST["quizId"];
$user = $_SESSION["user"]["userId"];
$quiz = sql_select_unique("SELECT * FROM quizes WHERE quizId = ? AND course = ? AND availableFrom < CURRENT_TIMESTAMP AND availableTo > CURRENT_TIMESTAMP",[$quizId,$_SESSION["course"]["id"]]);

if ($quiz === false) {
    exit();
}

$questions = sql_select("SELECT questionId FROM quiz_questions WHERE bank = ?",[$quiz["bank"]]);

$n = $quiz["questionCount"];
$randQuestions = $quiz["randomizeQuestions"] > 0;
$randAnswers = $quiz["randomizeAnswers"] > 0;

$selected = [];
shuffle($questions);

for ($i=0; $i < $n; $i++) { 
    $selected[$i] = $questions[$i]["questionId"];
}

sort($selected);

$qfid = sql_insert("quiz_fills",[
    "quiz" => $quizId,
    "user" => $user,
    "startTime" => getCurrentTime()
]);

$data = [];

for ($i=0; $i < $n; $i++) { 
    array_push($data,[$qfid,$selected[$i]]);
}

sql_multiple_insert("quiz_answers",["quizFillId","qid"],$data);


