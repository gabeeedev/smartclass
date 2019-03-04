<?php

$con = new PDO('mysql:host=localhost;dbname=test', "root", "");
$con->query("SET NAMES utf8");

function sql_select($sql, $array=array()) {
    GLOBAL $con;
    
    $query = $con->prepare($sql);
    $query->execute($array);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function sql_query($sql, $array=array()) {
    GLOBAL $con;
    
    $query = $con->prepare($sql);
    $query->execute($array);
}

function sql_insert($table, $array) {
    $data = [];
    foreach ($array as $k => $v) {
        data[":" . $k] = $v;
    }
    sql_query("INSERT INTO " . $table . " (" . implode(", ",array_keys($table)) . ") VALUES (" . implode(", ",array_keys($data)) . ")", $data);
}