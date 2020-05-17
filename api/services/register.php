<?php

require_once "../util/util.php";
require_once "../util/auth.php";

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

        $id = sql_insert("users",[
            "username"=>$username,
            "email"=>$email,
            "name"=>$name,
            "password"=>$password,      
        ]);
        
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