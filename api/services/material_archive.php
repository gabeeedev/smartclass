<?php

require_once "../util/auth.php";
require_once "../util/util.php";

loginDie();

$id = $_POST["id"];

sql_query("UPDATE materials SET status = " . E_ARCHIVED . " WHERE materialId = ? AND author = ?",[$id,$_SESSION["user"]["userId"]]);