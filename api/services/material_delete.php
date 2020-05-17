<?php

require_once "../util/auth.php";
require_once "../util/util.php";

loginDie();

$id = $_POST["id"];

$count = sql_delete("DELETE FROM materials WHERE materialId = ? AND author = ?",[$id,$_SESSION["user"]["userId"]]);
echo $count;

if ($count > 0) {
    $t = sql_query("DELETE FROM material_shared WHERE material = ?",[$id]);
    echo $t;

    $files = sql_select("SELECT * FROM material_files WHERE material = ?",[$id]);

    foreach($files as $row) {
        echo $row["file_path"];
        unlink("../../files/materials/" . $row["file_path"]);
    }

    $t = sql_query("DELETE FROM material_files WHERE material = ?",[$id]);
    echo $t;
}