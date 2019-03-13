<?php

require_once "../util/auth.php";
require_once "../util/util.php";


loginDie();

$data = [];

if(isset($_POST["courseToken"]) && strlen($_POST["courseToken"]) == 7) {
    $token = $_POST["courseToken"];
    
    $row = sql_select_unique("SELECT * FROM courses WHERE token = ?",[$token]);

    if($row !== false) {
        // $check = sql_select_unique("SELECT * FROM (SELECT * FROM attends UNION SELECT * FROM teaches) WHERE user = ? AND course = ?",[$_SESSION["user"]["userid"],$row["courseid"]])

        sql_insert("attends",[
            "user" => $_SESSION["user"]["userid"],
            "course" => $row["courseid"]
        ]);
            
        $data["id"] = $row["courseid"];
    } else {
        $data["error"] = "Invalid token!";
    }
} else {
    $data["error"] = "Invalid token!";
}

echo json_encode($data);