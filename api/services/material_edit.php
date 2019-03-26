<?php

require_once "../util/auth.php";
require_once "../util/util.php";

loginRedirect();

$response = [];

if (checkPostData(["materialTitle","materialContent"])) {
    $title = $_POST["materialTitle"];
    $content = $_POST["materialContent"];

    $mid = sql_insert("materials",["title" => $title, "content" => $content, "status" => E_ACTIVE, "author" => $_SESSION["user"]["userid"]]);

    foreach($_SESSION["materialFiles"] as $file) {
        sql_insert("material_files",["file_path" => $file["file"], "title" => $file["title"], "material" => $mid]);
    }

} else {
    $response["error"] = "Invalid fields";
}

echo json_encode($response);