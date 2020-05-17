<?php

session_start();

require_once "dbcon.php";

function makePassword($password) {
    return password_hash($password,PASSWORD_BCRYPT);
}

function checkPassword($password,$user) {
    return password_verify($password,$user["password"]);
}

function login($id) {
    $user = sql_select_unique("SELECT userId,name FROM users WHERE userId = ?",[$id]);
    // $settings = sql_select_unique("SELECT language,theme FROM user_settings WHERE usetid = ?",[$user['usetid']]);
    // $language = sql_select_unique("SELECT file FROM languages WHERE langid = ?",[$settings['language']]);
    // $theme = sql_select_unique("SELECT file FROM themes WHERE themeid = ?",[$settings['theme']]);
    $_SESSION["user"] = $user;
    // $_SESSION["user"]["settings"] = $settings;
    // $_SESSION["user"]["settings"]["language"] = $language["file"];
    // $_SESSION["user"]["settings"]["theme"] = $theme["file"];

    $roles = sql_select("SELECT roleid, title FROM user_role, roles WHERE roleid = role AND user = ?",[$user["userId"]]);
    $_SESSION["user"]["roles"] = $roles;
}

function getAccount($username, $email) {
    return sql_select_unique("SELECT * FROM users WHERE username = ? OR email = ?",[$username,$email]);
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

function hasRole($id) {
    foreach($_SESSION["user"]["roles"] as $role) {
        if ($role["roleid"] == $id) {
            return true;
        }
    }
    return false;
}