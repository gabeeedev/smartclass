<?php

require_once "../util/auth.php";
require_once "../util/util.php";


loginDie();

$data = [];
$error = false;

if(isset($_POST["courseToken"]) && strlen($_POST["courseToken"]) == 7) {
    $token = $_POST["courseToken"];
    
    $row = sql_select_unique("SELECT * FROM courses WHERE token = ?",[$token]);

    if($row !== false) {
        $attends = sql_select_unique("SELECT * FROM attends WHERE user = ? AND course = ?",[$_SESSION["user"]["userId"],$row["courseId"]]);
        $teaches = sql_select_unique("SELECT * FROM teaches WHERE user = ? AND course = ?",[$_SESSION["user"]["userId"],$row["courseId"]]);

        if ($attends !== false) {
            $data["error"] = "You are already attending this class.";
            $error = true;
        }

        if ($teaches !== false) {
            $data["error"] = "You are already teaching this class.";
            $error = true;
        }

    } else {
        $error = true;
        $data["error"] = "Token not found!";
    }
} else {
    $data["error"] = "Invalid token!";
    $error = true;
}

if (!$error) {
    sql_insert("attends",[
        "user" => $_SESSION["user"]["userId"],
        "course" => $row["courseId"]
    ]);
        
    $data["id"] = $row["courseId"];
}
echo json_encode($data);