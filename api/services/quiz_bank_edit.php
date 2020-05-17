<?php

require_once "../util/auth.php";
require_once "../util/util.php";

loginRedirect();

if (checkPostData(["bankTitle","bankQuestions"])) {

    $title = $_POST["bankTitle"];
    $questions = $_POST["bankQuestions"];

    $bankId = sql_insert("quiz_banks",[
        "title" => $title,
        "author" => $_SESSION["user"]["userId"]
    ]);

    $cols = ["question","bank"];
    $insert = [];

    foreach($questions as $question) {
        array_push($insert,[
            json_encode($question),
            $bankId
        ]);
    }

    sql_multiple_insert("quiz_questions",$cols,$insert);
}