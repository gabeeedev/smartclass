<?php

require_once "../util/auth.php";
require_once "../util/util.php";


loginDie();

$data = [];

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

    //setCurrentClass($cid);
    
    $data["id"] = $cid;
} else {
    $data["error"] = "The name of the course is too short.";
}

echo json_encode($data);