<?php

/**
 * Login
 * loginUsername - Username/E-mail
 * loginPassword - Password
 */

require_once "../util/auth.php";
require_once "../util/util.php";

// loginRedirect();

if (checkPostData(["loginUsername", "loginPassword"])) {

    $username = $_POST["loginUsername"];
    $password = $_POST["loginPassword"];

    $data = getAccount($username,$username);

    // $data = sql_select("SELECT * FROM users WHERE ( username = ? OR email = ? ) AND password = ?",[$username,$username,$password]);

    if($data !== false) {
        if(checkPassword($password,$data)) {
            login($data['userId']);
            echo "1";
        }
    }    
    else {
        echo "<div class='alert alert-danger' role='alert'>Invalid credentials!</div>";
    }
}
