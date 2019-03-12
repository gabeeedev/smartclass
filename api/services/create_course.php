<?php

require_once "../util/auth.php";
require_once "../util/util.php";


loginDie();

if(isset($_POST["courseName"]) && strlen($_POST["courseName"]) >= 3) {
    $token = generateToken(7);
    
    $cid = sql_insert("courses",[
        "title" => $_POST["courseName"],
        "token" => $token,
        "status" => "OPEN",
        "isPublic" => false
        // "modified" => "CURRENT_TIMESTAMP"
    ]);

    sql_insert("teaches",[
        "user" => $_SESSION["user"]["userid"],
        "course" => $cid
    ]);

    setCurrentClass($cid);
    
    echo "1";
} else {
    echo "The name of the course is too short.";
}