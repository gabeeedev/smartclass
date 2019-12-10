<?php

session_start();

require_once "dbcon.php";

function checkEmail() {

}

function makePassword($password) {
    return password_hash($password,PASSWORD_BCRYPT);
}

function checkPassword($password,$user) {
    return password_verify($password,$user["password"]);
}

function login($id) {
    $user = sql_select_unique("SELECT userid,name,settings FROM users WHERE userid = ?",[$id]);
    $settings = sql_select_unique("SELECT language,theme FROM user_settings WHERE usetid = ?",[$user['settings']]);
    $language = sql_select_unique("SELECT file FROM languages WHERE langid = ?",[$settings['language']]);
    $theme = sql_select_unique("SELECT file FROM themes WHERE themeid = ?",[$settings['theme']]);
    $_SESSION["user"] = $user;
    $_SESSION["user"]["settings"] = $settings;
    $_SESSION["user"]["settings"]["language"] = $language["file"];
    $_SESSION["user"]["settings"]["theme"] = $theme["file"];
}

function getAccount($username, $email) {
    $t = sql_select("SELECT * FROM users WHERE username = ? OR email = ?",[$username,$email]);
    return count($t) > 0 ? $t[0] : false;
}

function isLoggedIn() {
    return isset($_SESSION) && isset($_SESSION["user"]);
}

function loginRedirect() {
    if (!isLoggedIn()) {
        include("../pages/login.html");
        exit();
    }
}

function loginDie() {
    if (!isLoggedIn()) {
        exit();
    }
}