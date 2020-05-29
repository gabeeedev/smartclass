<?php

/**
 * New quiz
 * quizBank - Question bank
 * quizTitle - Quiz title
 * quizDescription - Quiz description
 * quizFrom - Quiz available from
 * quizTill - Quiz available till
 * quizQuestionCount - Amount of questions in the quiz
 * quizLength - Available time in minutes to fill out the quiz
 * quizRandomizeQuestions - Randomize questions in quiz
 * quizRandomizeAnswers - Randomize answers
 */

require_once "../util/course.php";
require_once "../util/util.php";

loginRedirect();
if (checkPostData(["quizBank","quizTitle","quizDescription","quizFrom","quizTill","quizQuestionCount","quizLength","quizRandomizeQuestions","quizRandomizeAnswers"]) && asTeacher()) {
    $id = sql_insert("quizes",[
        "bank" => $_POST["quizBank"],
        "title" => $_POST["quizTitle"],
        "description" => $_POST["quizDescription"],
        "availableFrom" => $_POST["quizFrom"],
        "availableTo" => $_POST["quizTill"],
        "questionCount" => $_POST["quizQuestionCount"],
        "length" => $_POST["quizLength"],
        "randomizeQuestions" => (isset($_POST["quizRandomizeQuestions"]) && $_POST["quizRandomizeQuestions"] == "true") ? 1 : 0,
        "randomizeAnswers" => (isset($_POST["quizRandomizeAnswers"]) && $_POST["quizRandomizeAnswers"] == "true") ? 1 : 0,
        "course" => $_SESSION["course"]["id"]
    ]);
}