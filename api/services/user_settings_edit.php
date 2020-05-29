<?php

/**
 * Set new password
 * settingsEmail - Email
 * settingsName - Name
 */

require_once "../util/util.php";
require_once "../util/auth.php";

loginRedirect();

if (checkPostData(["settingsEmail", "settingsName"])) { 

    $data = [
        "email" => $_POST["settingsEmail"],
        "name" => $_POST["settingsName"]
    ];
    
    sql_update_by_id("users",$data,"userId",$_SESSION["user"]["userId"]);

    // $data = [
    //     "language" => $_POST["settingsLanguage"],
    //     "theme" => $_POST["settingsTheme"]
    // ];

    // sql_update_by_id("user_settings",$data,"usetid",$_SESSION["user"]["usetid"]);

}