<?php

require_once "constants.php";

function checkPostData($fields) {
    foreach($fields as $v) {
        if(isset($_POST[$v]) && (is_array($_POST[$v]) || strlen($_POST[$v]) > 0)) {
            return true;
        }
    }
    return false;
}

function debug($v) {
    if (is_array($v)) {
        printArray($v);
    } else {
        echo $v;
    }
}

function printArray($data,$n = 0) {
    foreach ($data as $k => $v) {
        if(is_array($v)) {
            echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$n) . $k . " => {<br>";
            printArray($v,$n+1);
            echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$n) . "}<br>";
        } else {
            echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$n) . $k . " => " . $v . "<br>";
        }
    }
}

function generateToken($len) {
    $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $token = "";
    for ($i=0; $i < $len; $i++) { 
        $token .= $chars[rand(0,strlen($chars)-1)];
    }
    return $token;
}

function getFile($file) {
    $ext = explode(".",$file);
    $name = array_splice($ext,0,count($ext)-1);
    return ["name" => implode(".",$name), "ext" => $ext[0]];
}

function writeConfig($res,$data) {
    fwrite($res,"<?php" . PHP_EOL . PHP_EOL);
    foreach ($data as $k => $v) {        
        fwrite($res,"$" . $k . " = '" . $v . "';" . PHP_EOL);
    }
}