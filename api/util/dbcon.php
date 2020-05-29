<?php

require_once "config.php";

$con = new PDO("mysql:host=" . $mysqlAddress . ";dbname=" . $mysqlDatabase, $mysqlUsername, $mysqlPassword);
$con->query("SET NAMES utf8");

function sql_error($query) {
    $error = $query->errorInfo();
    if (count($error) > 2 && strlen($error[2]) > 0) {
        echo "<b>SQL Error</b>: " . $error[2];
    }
}

function sql_select($sql, $data=array()) {
    GLOBAL $con;
    
    $query = $con->prepare($sql);
    $success = $query->execute($data);
    if(!$success) { sql_error($query); return false; }
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function sql_select_unique($sql,$data=array()) {
    GLOBAL $con;
    
    $query = $con->prepare($sql);
    $success = $query->execute($data);
    if(!$success) { sql_error($query); return false; }
    return $query->fetch(PDO::FETCH_ASSOC);
}

function sql_select_array($sql, $data=array()) {
    GLOBAL $con;
    
    $query = $con->prepare($sql);
    $success = $query->execute($data);
    if(!$success) { sql_error($query); return false; }
    return $query->fetchAll(PDO::FETCH_NUM);
}

function sql_query($sql, $data=array()) {
    GLOBAL $con;
    
    $query = $con->prepare($sql);
    $success = $query->execute($data);
    if(!$success) { sql_error($query); return false; }
    return true;
}

function sql_insert($table, $data) {
    GLOBAL $con;

    $spec = [];
    foreach ($data as $k => $v) {
        $spec[":" . $k] = $v;
    }
    $success = sql_query("INSERT INTO " . $table . " (" . implode(", ",array_keys($data)) . ") VALUES (" . implode(", ",array_keys($spec)) . ")", $spec);
    if(!$success) { return false; }
    return $con->lastInsertId();
}

function sql_update_by_id($table,$data,$idcol,$id) {
    GLOBAL $con;

    $cols = [];
    foreach ($data as $k => $v) {
        $cols[] = $k . " = " . ":" . $k;
    }

    $data[$idcol] = $id;

    return sql_query("UPDATE " . $table . " SET " . implode(", ",$cols) . " WHERE " . $idcol . " = :" . $idcol,$data);
}

function sql_delete($sql,$data = array()) {
    GLOBAL $con;

    $query = $con->prepare($sql);
    $query->execute($data);
    return $query->rowCount();
}

function sql_multiple_insert($table,$cols,$datas) {
    GLOBAL $con;

    $valq = "(";

    for ($i=0; $i < count($cols)-1; $i++) { 
        $valq .= "?, ";
    }

    $valq .= "?)";

    $sql = "INSERT INTO " . $table . " (" . implode(", ",array_values($cols)) . ") VALUES " . $valq;
    $query = $con->prepare($sql);

    $ids = [];
    
    foreach($datas as $data) {
        $query->execute($data);
        sql_error($query);
        array_push($ids,$con->lastInsertId());
    }

    return $ids;
}

function sql_multiple_update_by_id($table,$idcols,$cols,$datas) {
    GLOBAL $con;
    
    $it = [];

    foreach($idcols as $v) {
        array_push($it,$v . " = ?");
    }

    $dt = [];

    foreach($cols as $v) {
        array_push($dt,$v . " = ?");
    }    

    $sql = "UPDATE $table SET " . implode(", ",$dt) . " WHERE " . implode(" AND ", $it);
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