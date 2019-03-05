<?php

session_start();

require_once 'dbcon.php';

function checkEmail() {

}

function registerAccount($data) {

}

function isLoggedIn() {
    if (!isset($_SESSION) || !isset($_SESSION['login'])) {
        return false;
    }
}