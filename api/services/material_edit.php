<?php

require_once "../util/auth.php";
require_once "../util/util.php";

loginRedirect();

$response = [];

if (checkPostData(["materialTitle","materialContent"])) {

    $edit = false;

    if (isset($_POST["edit"])) {
        $editrow = sql_select_unique("SELECT * FROM materials WHERE materialId = ? AND author = ?",[$_POST["edit"],$_SESSION["user"]["userId"]]);
        $edit = $editrow !== false;
    }

    $title = $_POST["materialTitle"];
    $content = $_POST["materialContent"];

    if ($edit) {
        $mid = $_POST["edit"];
        sql_update_by_id("materials",["title" => $title, "content" => $content],"materialId",$mid);
    } else {
        $mid = sql_insert("materials",["title" => $title, "content" => $content, "status" => E_ACTIVE, "author" => $_SESSION["user"]["userId"]]);
    }    

    foreach($_SESSION["materialFiles"] as $file) {
        sql_insert("material_files",["filePath" => $file["file"], "title" => $file["title"], "material" => $mid]);
    }
    $_SESSION["materialFiles"] = [];
    $response["success"] = true;

} else {
    $response["error"] = "Invalid fields";
}

echo json_encode($response);