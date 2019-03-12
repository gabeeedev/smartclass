<?php

require_once "../util/auth.php";
require_once "../util/util.php";

// loginRedirect();

if (checkPostData(["username", "password"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $data = getAccount($username,$username);

    // $data = sql_select("SELECT * FROM users WHERE ( username = ? OR email = ? ) AND password = ?",[$username,$username,$password]);

    if($data !== false) {
        if(checkPassword($password,$data)) {
            login($data['userid']);
        }
    }    
}
