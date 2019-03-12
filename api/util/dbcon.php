<?php

$con = new PDO('mysql:host=localhost;dbname=smartclass', "root", "");
$con->query("SET NAMES utf8");

function sql_select($sql, $array=array()) {
    GLOBAL $con;
    
    $query = $con->prepare($sql);
    $query->execute($array);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function sql_select_unique($sql,$array=array()) {
    GLOBAL $con;
    
    $query = $con->prepare($sql);
    $query->execute($array);
    return $query->fetch(PDO::FETCH_ASSOC);
}

function sql_select_array($sql, $array=array()) {
    GLOBAL $con;
    
    $query = $con->prepare($sql);
    $query->execute($array);
    return $query->fetchAll(PDO::FETCH_ARRAY);
}

function sql_query($sql, $array=array()) {
    GLOBAL $con;
    
    $query = $con->prepare($sql);
    $query->execute($array);
}

function sql_insert($table, $array) {
    GLOBAL $con;

    $data = [];
    foreach ($array as $k => $v) {
        $data[":" . $k] = $v;
    }
    sql_query("INSERT INTO " . $table . " (" . implode(", ",array_keys($array)) . ") VALUES (" . implode(", ",array_keys($data)) . ")", $data);
    return $con->lastInsertId();
}