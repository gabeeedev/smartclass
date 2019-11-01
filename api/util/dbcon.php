<?php

require_once "config.php";

$con = new PDO("mysql:host=" . $mysqlAddress . ";dbname=" . $mysqlDatabase, $mysqlUsername, $mysqlPassword);
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

function sql_update_by_id($table,$array,$idcol,$id) {
    GLOBAL $con;

    $data = [];
    foreach ($array as $k => $v) {
        $data[":" . $k] = $v;
    }
    $data[":" . $idcol] = $id;
    $cols = [];
    foreach ($array as $k => $v) {
        $cols[] = $k . " = " . ":" . $k;
    }
    sql_query("UPDATE " . $table . " SET " . implode(", ",$cols) . " WHERE " . $idcol . " = :" . $idcol,$data);
}

function sql_multiple_insert($table,$cols,$datas) {
    GLOBAL $con;

    $valq = "(";

    for ($i=0; $i < count($cols)-1; $i++) { 
        $valq .= "?,";
    }

    $valq .= "?)";

    $sql = "INSERT INTO " . $table . " (" . implode(", ",array_values($cols)) . ") VALUES " . $valq;
    $query = $con->prepare($sql);

    $ids = [];
    
    foreach($datas as $data) {
        $query->execute($data);
        array_push($ids,$con->lastInsertId());
    }

    return $ids;
}

function sql_multiple_update_by_id($table,$idcol,$cols,$datas) {
    GLOBAL $con;

    $t = [];

    foreach($cols as $v) {
        array_push($t,$v . " = ?");
    }    

    $sql = "UPDATE $table SET " . implode(", ",$t) . " WHERE $idcol = ?";
    $query = $con->prepare($sql);

    
    foreach($datas as $data) {
        $query->execute($data);
    }
}

function sql_multiple_delete_by_id($table,$id,$data) {
    GLOBAL $con;

    $sql = "DELETE FROM $table WHERE $id = ?";
    $query = $con->prepare($sql);

    foreach($data as $v) {
        $query->execute([$v]);
    }
}