<?php

include "../util/util.php";
include "../util/auth.php";

if (checkPostData(["registerUsername", "registerEmail", "registerName", "registerPassword", "registerRepeatPassword"])) {
    $username = $_POST["registerUsername"];
    $email = $_POST["registerEmail"];
    $name = $_POST["registerName"];
    $password = $_POST["registerPassword"];
    $repeatPassword = $_POST["registerRepeatPassword"];

    $error = [];
    $test = true;

    $test = $test && $password == $repeatPassword;
    if(!$test) $error[] = "The passwords are different!";
    
    $account = getAccount($username,$email);
    if($account !== false) {
        $test = false;
        if($account['username'] == $username) $error[] = "Username is already in use!";
        if($account['email'] == $email) $error[] = "Email is already in use!";
    }
    
    if ($test) {

        $password = makePassword($password);

        $settings = sql_insert("user_settings",[
            "language"=>1,
            "theme"=>1
        ]);

        $id = sql_insert("users",[
            "username"=>$username,
            "email"=>$email,
            "name"=>$name,
            "password"=>$password,      
            "settings"=>$settings  
        ]);

        

        // $account = sql_select_unique("SELECT userid,username,name FROM users WHERE username = ?",[$username]);

        // $con->lastInsertId();

        // $_SESSION['login'] = $account[0];

        login($id);

        echo "1";
    } else {
        foreach($error as $v) {
            echo "<div class='alert alert-danger' role='alert'>" . $v . "</div>";
        }
    }
    
    

} else {
    echo "<div class='alert alert-danger' role='alert'>All fields are required!</div>";
}
?>