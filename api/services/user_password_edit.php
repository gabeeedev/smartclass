<?php

/**
 * Set new password
 * settingsOldPassword - Old password
 * settingsPassword - Password
 * settingsRepeatPassword Repeat password
 */

require_once "../util/util.php";
require_once "../util/auth.php";

loginRedirect();

if (checkPostData(["settingsOldPassword","settingsPassword", "settingsRepeatPassword"])) { 

    $user = sql_select_unique("SELECT password FROM users WHERE userId = ?",[$_SESSION["user"]["userId"]]);

    $error = false;

    if ($_POST["settingsPassword"] != $_POST["settingsRepeatPassword"]) {
        $error = true;
        echo "<div class='alert alert-danger' role='alert'>The passwords are different!</div>";
    }

    if (!checkPassword($_POST["settingsOldPassword"],$user)) {
        $error = true;
        echo "<div class='alert alert-danger' role='alert'>Invalid old password!</div>";
    }
    
    if (!$error) {
        $data = [
            "password" => makePassword($_POST["settingsPassword"])
        ];
        
        sql_update_by_id("users",$data,"userId",$_SESSION["user"]["userId"]);
        echo "1";
    }
}
else {
    echo "<div class='alert alert-danger' role='alert'>All fields are required!</div>";
}