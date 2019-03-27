<?php

require_once "../util/auth.php";
require_once "../util/util.php";

loginRedirect();

$response = [];

if (checkPostData(["materialTitle","materialContent"])) {

    $edit = false;

    if (isset($_POST["edit"])) {
        $editrow = sql_select_unique("SELECT * FROM materials WHERE materialid = ? AND author = ?",[$_POST["edit"],$_SESSION["user"]["userid"]]);
        $edit = $editrow !== false;
    }

    $title = $_POST["materialTitle"];
    $content = $_POST["materialContent"];

    if ($edit) {
        $mid = $_POST["edit"];
        sql_update_by_id("materials",["title" => $title, "content" => $content],"materialid",$mid);
    } else {
        $mid = sql_insert("materials",["title" => $title, "content" => $content, "status" => E_ACTIVE, "author" => $_SESSION["user"]["userid"]]);
    }    

    foreach($_SESSION["materialFiles"] as $file) {
        sql_insert("material_files",["file_path" => $file["file"], "title" => $file["title"], "material" => $mid]);
    }
    $_SESSION["materialFiles"] = [];
    $response["success"] = true;

} else {
    $response["error"] = "Invalid fields";
}

echo json_encode($response);