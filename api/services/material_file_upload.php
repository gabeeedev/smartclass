<?php

require_once "../util/auth.php";
require_once "../util/util.php";

loginRedirect();

$response = [];

if (isset($_POST["materialFileTitle"]) && isset($_FILES["materialFile"]) && $_FILES["materialFile"]["error"] == 0) {

$title = $_POST["materialFileTitle"];
$file = generateToken(16) . "." . array_slice(explode(".",$_FILES["materialFile"]["name"]),-1)[0];

$_SESSION["materialFiles"][] = ["title" => $title, "file" => $file];
move_uploaded_file($_FILES["materialFile"]["tmp_name"],"../../files/materials/" . $file);

    $response["success"] = true;
    $response["title"] = $title;
    $response["file"] = $file;

} else {
    $response["error"] = "Incorrect fields";
}

echo json_encode($response);