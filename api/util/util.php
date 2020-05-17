<?php

require_once "constants.php";

function checkPostData($fields) {
    foreach($fields as $v) {
        if(!isset($_POST[$v]) || !(is_array($_POST[$v]) || strlen($_POST[$v]) > 0)) {
            return false;
        }
    }
    return true;
}

function debug($v) {
    if (is_array($v)) {
        printArray($v);
    } else {
        echo $v . "<br>\n";
    }
}

function printArray($data,$n = 0) {
    foreach ($data as $k => $v) {
        if(is_array($v)) {
            echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$n) . $k . " => {<br>\n";
            printArray($v,$n+1);
            echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$n) . "}<br>\n";
        } else {
            echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$n) . $k . " => " . $v . "<br>\n";
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

function downloadFile($path,$name) {
    $ext = end(explode(".",$path));

    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=" . $name . "." . $ext);
    ob_clean();

    readfile("../../files/" . $path);
}

function timeDiff($a,$b) {
    return strtotime($a) - strtotime($b);
}

function getCurrentTime() {
    return date("Y-m-d h:i:s");
}