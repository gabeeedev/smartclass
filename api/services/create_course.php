<?php

require_once "../util/auth.php";
require_once "../util/util.php";


loginDie();

$data = [];

if(isset($_POST["courseName"]) && strlen($_POST["courseName"]) >= 3) {
    $token = generateToken(7);

    // $cset = sql_insert("course_settings", [
    //     "default_assignment" => -1,
    //     "default_grading" => -1
    // ]);
    
    $cid = sql_insert("courses",[
        "title" => $_POST["courseName"],
        "token" => $token,
        "status" => "OPEN"
        // "settings" => $cset
    ]);

    sql_insert("teaches",[
        "user" => $_SESSION["user"]["userId"],
        "course" => $cid
    ]);

    //setCurrentClass($cid);
    
    $data["id"] = $cid;
} else {
    $data["error"] = "The name of the course is too short.";
}

echo json_encode($data);